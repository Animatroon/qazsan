<?php

namespace App;

class Options
{
    public static function register(): void
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title'  => __('Настройки сайта', 'qazaqstan'),
                'menu_title'  => __('Настройки сайта', 'qazaqstan'),
                'menu_slug'   => 'qazaqstan-settings',
                'capability'  => 'manage_options',
                'icon_url'    => 'dashicons-admin-settings',
                'position'    => 2,
                'redirect'    => false,
            ]);

            acf_add_options_sub_page([
                'page_title'  => __('Контакты и реквизиты', 'qazaqstan'),
                'menu_title'  => __('Контакты', 'qazaqstan'),
                'parent_slug' => 'qazaqstan-settings',
                'menu_slug'   => 'qazaqstan-contacts',
            ]);

            acf_add_options_sub_page([
                'page_title'  => __('Скидки и цены', 'qazaqstan'),
                'menu_title'  => __('Скидки и цены', 'qazaqstan'),
                'parent_slug' => 'qazaqstan-settings',
                'menu_slug'   => 'qazaqstan-prices',
            ]);

            acf_add_options_sub_page([
                'page_title'  => __('Соцсети и аналитика', 'qazaqstan'),
                'menu_title'  => __('Соцсети', 'qazaqstan'),
                'parent_slug' => 'qazaqstan-settings',
                'menu_slug'   => 'qazaqstan-social',
            ]);
        } else {
            self::registerNative();
        }
    }

    private static function registerNative(): void
    {
        add_action('admin_menu', function () {
            add_menu_page(
                __('Настройки сайта', 'qazaqstan'),
                __('Настройки сайта', 'qazaqstan'),
                'manage_options',
                'qazaqstan-settings',
                [self::class, 'renderPage'],
                'dashicons-admin-settings',
                2
            );
        });

        add_action('admin_init', [self::class, 'registerFields']);
    }

    public static function registerFields(): void
    {
        $fields = [
            'address', 'email', 'phone_primary', 'phone_secondary',
            'work_hours', 'map_lat', 'map_lng',
            'instagram', 'telegram', 'whatsapp', 'facebook',
            'gtm_id', 'ga4_id', 'metrika_id',
            'discount_pensioner', 'discount_mvd_active', 'discount_mvd_retired',
            'package_includes',
        ];

        foreach ($fields as $field) {
            register_setting('qazaqstan_settings', 'qazaqstan_' . $field, [
                'sanitize_callback' => 'sanitize_text_field',
            ]);
        }
    }

    public static function renderPage(): void
    {
        if (! current_user_can('manage_options')) {
            return;
        }

        if (isset($_POST['_wpnonce']) && wp_verify_nonce(sanitize_key($_POST['_wpnonce']), 'qazaqstan_settings')) {
            foreach ($_POST as $key => $value) {
                if (str_starts_with($key, 'qazaqstan_')) {
                    update_option(sanitize_key($key), sanitize_text_field(wp_unslash((string) $value)));
                }
            }
            echo '<div class="notice notice-success"><p>' . esc_html__('Настройки сохранены.', 'qazaqstan') . '</p></div>';
        }

        $fields = [
            'address'            => __('Адрес', 'qazaqstan'),
            'email'              => __('Email', 'qazaqstan'),
            'phone_primary'      => __('Телефон основной', 'qazaqstan'),
            'phone_secondary'    => __('Телефон дополнительный', 'qazaqstan'),
            'work_hours'         => __('Режим работы', 'qazaqstan'),
            'map_lat'            => __('Координата (широта)', 'qazaqstan'),
            'map_lng'            => __('Координата (долгота)', 'qazaqstan'),
            'instagram'          => __('Instagram URL', 'qazaqstan'),
            'telegram'           => __('Telegram URL', 'qazaqstan'),
            'whatsapp'           => __('WhatsApp номер', 'qazaqstan'),
            'gtm_id'             => __('GTM ID', 'qazaqstan'),
            'ga4_id'             => __('GA4 Measurement ID', 'qazaqstan'),
            'metrika_id'         => __('Яндекс.Метрика ID', 'qazaqstan'),
            'discount_pensioner' => __('Скидка пенсионерам (%)', 'qazaqstan'),
            'discount_mvd_active'  => __('Скидка сотрудникам МВД (%)', 'qazaqstan'),
            'discount_mvd_retired' => __('Скидка пенсионерам МВД (%)', 'qazaqstan'),
        ];
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Настройки сайта QAZAQSTAN Resort', 'qazaqstan'); ?></h1>
            <form method="post">
                <?php wp_nonce_field('qazaqstan_settings'); ?>
                <table class="form-table" role="presentation">
                <?php foreach ($fields as $key => $label) : ?>
                    <tr>
                        <th scope="row"><label for="qazaqstan_<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label></th>
                        <td><input type="text" id="qazaqstan_<?php echo esc_attr($key); ?>" name="qazaqstan_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr(get_option('qazaqstan_' . $key)); ?>" class="regular-text"></td>
                    </tr>
                <?php endforeach; ?>
                </table>
                <?php submit_button(__('Сохранить настройки', 'qazaqstan')); ?>
            </form>
        </div>
        <?php
    }
}
