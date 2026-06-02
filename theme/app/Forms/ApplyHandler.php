<?php

namespace App\Forms;

class ApplyHandler
{
    public static function register(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route('qazaqstan/v1', '/apply', [
                'methods'             => 'POST',
                'callback'            => [self::class, 'handle'],
                'permission_callback' => '__return_true',
            ]);
        });
    }

    public static function handle(\WP_REST_Request $request): \WP_REST_Response
    {
        if (!wp_verify_nonce($request->get_param('_wpnonce'), 'qazaqstan_apply')) {
            return new \WP_REST_Response(['success' => false, 'message' => __('Ошибка безопасности.', 'qazaqstan')], 403);
        }

        if (!empty($request->get_param('website'))) {
            return new \WP_REST_Response(['success' => true], 200);
        }

        $v = new Validator($request->get_params());
        $v->required('name', __('ФИО', 'qazaqstan'))
          ->required('phone', __('Телефон', 'qazaqstan'))
          ->phone('phone')
          ->email('email')
          ->maxLength('message', 3000);

        if (!$v->passes()) {
            return new \WP_REST_Response(['success' => false, 'errors' => $v->errors()], 422);
        }

        $name       = $v->get('name');
        $phone      = $v->get('phone');
        $email      = $v->email_value('email');
        $message    = $v->textarea('message');
        $position   = $v->get('position');
        $vacancyId  = $v->int('vacancy_id');
        $vacancyTitle = $vacancyId ? get_the_title($vacancyId) : $position;

        $title = sprintf('%s · %s', $name, $vacancyTitle ?: __('Общий отклик', 'qazaqstan'));

        $postId = wp_insert_post([
            'post_type'    => 'appeal',
            'post_title'   => sanitize_text_field($title),
            'post_content' => $message,
            'post_status'  => 'publish',
        ]);

        if (is_wp_error($postId)) {
            return new \WP_REST_Response(['success' => false, 'message' => __('Ошибка сервера.', 'qazaqstan')], 500);
        }

        $meta = [
            'appeal_type'     => 'vacancy',
            'appeal_name'     => $name,
            'appeal_phone'    => $phone,
            'appeal_email'    => $email,
            'appeal_position' => $vacancyTitle,
            'appeal_vacancy'  => $vacancyId,
            'appeal_status'   => 'new',
        ];
        foreach ($meta as $key => $value) {
            update_post_meta($postId, $key, $value);
        }

        $body  = '<h2 style="color:#3872B8;margin-top:0;">' . __('Отклик на вакансию', 'qazaqstan') . '</h2>';
        $body .= Notifier::row(__('Кандидат', 'qazaqstan'), $name);
        $body .= Notifier::row(__('Телефон', 'qazaqstan'), $phone);
        if ($email)       $body .= Notifier::row('Email', $email);
        if ($vacancyTitle) $body .= Notifier::row(__('Вакансия', 'qazaqstan'), $vacancyTitle);
        if ($message)     $body .= sprintf('<div style="margin-top:16px;padding:16px;background:#F8F9F6;border-radius:8px;"><p style="margin:0;white-space:pre-wrap;">%s</p></div>', esc_html($message));

        Notifier::send(__('Отклик на вакансию', 'qazaqstan') . ': ' . $name, $body, $email ?: null);

        return new \WP_REST_Response([
            'success' => true,
            'message' => __('Резюме отправлено! Свяжемся с вами в ближайшее время.', 'qazaqstan'),
        ], 200);
    }
}
