<?php

namespace App\Forms;

class BookingHandler
{
    public static function register(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route('qazaqstan/v1', '/booking', [
                'methods'             => 'POST',
                'callback'            => [self::class, 'handle'],
                'permission_callback' => '__return_true',
            ]);
        });
    }

    public static function handle(\WP_REST_Request $request): \WP_REST_Response
    {
        if (!wp_verify_nonce($request->get_param('_wpnonce'), 'qazaqstan_booking')) {
            return new \WP_REST_Response(['success' => false, 'message' => __('Ошибка безопасности. Обновите страницу.', 'qazaqstan')], 403);
        }

        if (!empty($request->get_param('website'))) {
            return new \WP_REST_Response(['success' => true], 200);
        }

        $v = new Validator($request->get_params());

        $v->required('name', __('Имя', 'qazaqstan'))
          ->required('phone', __('Телефон', 'qazaqstan'))
          ->phone('phone')
          ->email('email')
          ->maxLength('comment', 1000);

        if (!$v->passes()) {
            return new \WP_REST_Response(['success' => false, 'errors' => $v->errors()], 422);
        }

        $name      = $v->get('name');
        $phone     = $v->get('phone');
        $email     = $v->email_value('email');
        $checkin   = $v->get('checkin');
        $checkout  = $v->get('checkout');
        $roomType  = $v->get('room_type');
        $guests    = $v->int('guests');
        $discount  = $v->get('discount_category');
        $comment   = $v->textarea('comment');

        $roomTitle = '';
        if (is_numeric($roomType)) {
            $room = get_post((int) $roomType);
            $roomTitle = $room ? $room->post_title : $roomType;
        } else {
            $roomTitle = $roomType;
        }

        $title = sprintf('%s · %s', $name, $checkin ?: current_time('d.m.Y'));

        $postId = wp_insert_post([
            'post_type'   => 'booking_request',
            'post_title'  => sanitize_text_field($title),
            'post_status' => 'publish',
        ]);

        if (is_wp_error($postId)) {
            return new \WP_REST_Response(['success' => false, 'message' => __('Ошибка сохранения. Позвоните нам напрямую.', 'qazaqstan')], 500);
        }

        $fields = [
            'br_name'      => $name,
            'br_phone'     => $phone,
            'br_email'     => $email,
            'br_checkin'   => $checkin,
            'br_checkout'  => $checkout,
            'br_room_type' => $roomTitle,
            'br_guests'    => $guests,
            'br_comment'   => $comment,
            'br_status'    => 'new',
            'br_discount'  => $discount,
        ];

        if (function_exists('update_field')) {
            foreach ($fields as $key => $value) {
                update_field($key, $value, $postId);
            }
        } else {
            foreach ($fields as $key => $value) {
                update_post_meta($postId, $key, $value);
            }
        }

        $body  = '<h2 style="color:#3872B8;margin-top:0;">Новая заявка на бронирование</h2>';
        $body .= Notifier::row(__('Имя', 'qazaqstan'), $name);
        $body .= Notifier::row(__('Телефон', 'qazaqstan'), $phone);
        if ($email)     $body .= Notifier::row('Email', $email);
        if ($checkin)   $body .= Notifier::row(__('Заезд', 'qazaqstan'), $checkin);
        if ($checkout)  $body .= Notifier::row(__('Выезд', 'qazaqstan'), $checkout);
        if ($roomTitle) $body .= Notifier::row(__('Тип номера', 'qazaqstan'), $roomTitle);
        if ($guests)    $body .= Notifier::row(__('Гостей', 'qazaqstan'), (string) $guests);
        if ($discount)  $body .= Notifier::row(__('Льготная категория', 'qazaqstan'), $discount);
        if ($comment)   $body .= Notifier::row(__('Комментарий', 'qazaqstan'), $comment);
        $body .= sprintf('<p style="margin-top:20px;"><a href="%s" style="background:#3872B8;color:#fff;padding:10px 20px;border-radius:6px;text-decoration:none;">%s</a></p>',
            esc_url(admin_url('post.php?post=' . $postId . '&action=edit')),
            __('Открыть заявку', 'qazaqstan')
        );

        Notifier::send(__('Заявка на бронирование', 'qazaqstan') . ' #' . $postId, $body, $email ?: null);

        return new \WP_REST_Response([
            'success' => true,
            'message' => __('Заявка принята! Менеджер свяжется с вами в течение 30 минут.', 'qazaqstan'),
        ], 200);
    }
}
