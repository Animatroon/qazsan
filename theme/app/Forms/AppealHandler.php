<?php

namespace App\Forms;

class AppealHandler
{
    private const TYPES = ['general', 'booking', 'complaint', 'president', 'corruption'];

    public static function register(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route('qazaqstan/v1', '/appeal', [
                'methods'             => 'POST',
                'callback'            => [self::class, 'handle'],
                'permission_callback' => '__return_true',
            ]);
        });
    }

    public static function handle(\WP_REST_Request $request): \WP_REST_Response
    {
        if (!wp_verify_nonce($request->get_param('_wpnonce'), 'qazaqstan_appeal')) {
            return new \WP_REST_Response(['success' => false, 'message' => __('Ошибка безопасности.', 'qazaqstan')], 403);
        }

        if (!empty($request->get_param('website'))) {
            return new \WP_REST_Response(['success' => true], 200);
        }

        $v = new Validator($request->get_params());

        $appealType = sanitize_key($request->get_param('appeal_type') ?? 'general');
        if (!in_array($appealType, self::TYPES, true)) {
            $appealType = 'general';
        }

        $isCorruption = ($appealType === 'corruption');

        if (!$isCorruption) {
            $v->required('name', __('ФИО', 'qazaqstan'));
            $v->required('phone', __('Телефон', 'qazaqstan'));
            $v->phone('phone');
        }
        $v->required('message', __('Сообщение', 'qazaqstan'))
          ->maxLength('message', 5000)
          ->email('email');

        if (!$v->passes()) {
            return new \WP_REST_Response(['success' => false, 'errors' => $v->errors()], 422);
        }

        $name    = $v->get('name') ?: __('Аноним', 'qazaqstan');
        $phone   = $v->get('phone');
        $email   = $v->email_value('email');
        $message = $v->textarea('message');
        $contact = $v->get('contact');

        $typeLabels = [
            'general'    => __('Общий вопрос', 'qazaqstan'),
            'booking'    => __('Вопрос по бронированию', 'qazaqstan'),
            'complaint'  => __('Жалоба / предложение', 'qazaqstan'),
            'president'  => __('Обращение к руководству', 'qazaqstan'),
            'corruption' => __('Сообщение о коррупции', 'qazaqstan'),
        ];

        $typeLabel = $typeLabels[$appealType];
        $title = sprintf('%s · %s', $typeLabel, $name);

        $postId = wp_insert_post([
            'post_type'    => 'appeal',
            'post_title'   => sanitize_text_field($title),
            'post_content' => $message,
            'post_status'  => 'publish',
        ]);

        if (is_wp_error($postId)) {
            return new \WP_REST_Response(['success' => false, 'message' => __('Ошибка сервера. Напишите нам на email напрямую.', 'qazaqstan')], 500);
        }

        $meta = [
            'appeal_type'    => $appealType,
            'appeal_name'    => $name,
            'appeal_phone'   => $phone,
            'appeal_email'   => $email,
            'appeal_contact' => $contact,
            'appeal_status'  => 'new',
        ];

        if (function_exists('update_field')) {
            foreach ($meta as $key => $value) {
                update_field($key, $value, $postId);
            }
        } else {
            foreach ($meta as $key => $value) {
                update_post_meta($postId, $key, $value);
            }
        }

        $body  = sprintf('<h2 style="color:#3872B8;margin-top:0;">%s</h2>', esc_html($typeLabel));
        $body .= Notifier::row(__('От', 'qazaqstan'), $name);
        if ($phone)   $body .= Notifier::row(__('Телефон', 'qazaqstan'), $phone);
        if ($email)   $body .= Notifier::row('Email', $email);
        if ($contact) $body .= Notifier::row(__('Контакт', 'qazaqstan'), $contact);
        $body .= sprintf('<div style="margin-top:16px;padding:16px;background:#F8F9F6;border-radius:8px;border-left:4px solid #3872B8;"><p style="margin:0;white-space:pre-wrap;">%s</p></div>', esc_html($message));
        $body .= sprintf('<p style="margin-top:20px;"><a href="%s" style="background:#3872B8;color:#fff;padding:10px 20px;border-radius:6px;text-decoration:none;">%s</a></p>',
            esc_url(admin_url('post.php?post=' . $postId . '&action=edit')),
            __('Открыть обращение', 'qazaqstan')
        );

        Notifier::send($typeLabel . ' #' . $postId, $body, $email ?: null);

        $messages = [
            'general'    => __('Спасибо! Ответим в течение одного рабочего дня.', 'qazaqstan'),
            'booking'    => __('Заявка принята! Менеджер свяжется с вами в течение 30 минут.', 'qazaqstan'),
            'complaint'  => __('Жалоба зарегистрирована. Рассмотрим в течение 10 рабочих дней.', 'qazaqstan'),
            'president'  => __('Обращение направлено. Ответ — в установленные законом сроки.', 'qazaqstan'),
            'corruption' => __('Обращение принято. Конфиденциальность гарантируется.', 'qazaqstan'),
        ];

        return new \WP_REST_Response([
            'success' => true,
            'message' => $messages[$appealType],
        ], 200);
    }
}
