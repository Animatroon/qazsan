<?php

namespace App\Fields;

class GlobalOptionsFields
{
    public static function register(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key'      => 'group_contacts_options',
            'title'    => __('Контакты и реквизиты', 'qazaqstan'),
            'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'qazaqstan-contacts']]],
            'fields'   => [
                [
                    'key'   => 'field_address',
                    'label' => __('Адрес', 'qazaqstan'),
                    'name'  => 'address',
                    'type'  => 'text',
                    'default_value' => 'г. Алматы, пр. Достык, 308',
                ],
                [
                    'key'      => 'field_phones',
                    'label'    => __('Телефоны', 'qazaqstan'),
                    'name'     => 'phones',
                    'type'     => 'repeater',
                    'layout'   => 'table',
                    'min'      => 1,
                    'button_label' => __('Добавить телефон', 'qazaqstan'),
                    'sub_fields' => [
                        [
                            'key'   => 'field_phone_number',
                            'label' => __('Номер', 'qazaqstan'),
                            'name'  => 'number',
                            'type'  => 'text',
                        ],
                        [
                            'key'   => 'field_phone_label',
                            'label' => __('Подпись', 'qazaqstan'),
                            'name'  => 'label',
                            'type'  => 'text',
                        ],
                    ],
                ],
                [
                    'key'   => 'field_email',
                    'label' => __('Email', 'qazaqstan'),
                    'name'  => 'email',
                    'type'  => 'email',
                ],
                [
                    'key'   => 'field_work_hours',
                    'label' => __('Режим работы', 'qazaqstan'),
                    'name'  => 'work_hours',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_map_lat',
                    'label' => __('Широта (lat)', 'qazaqstan'),
                    'name'  => 'map_lat',
                    'type'  => 'text',
                    'default_value' => '43.2220',
                ],
                [
                    'key'   => 'field_map_lng',
                    'label' => __('Долгота (lng)', 'qazaqstan'),
                    'name'  => 'map_lng',
                    'type'  => 'text',
                    'default_value' => '76.9458',
                ],
                [
                    'key'   => 'field_requisites',
                    'label' => __('Реквизиты организации', 'qazaqstan'),
                    'name'  => 'requisites',
                    'type'  => 'textarea',
                    'rows'  => 6,
                ],
            ],
        ]);

        acf_add_local_field_group([
            'key'      => 'group_prices_options',
            'title'    => __('Скидки и путёвки', 'qazaqstan'),
            'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'qazaqstan-prices']]],
            'fields'   => [
                [
                    'key'          => 'field_discounts',
                    'label'        => __('Скидки', 'qazaqstan'),
                    'name'         => 'discounts',
                    'type'         => 'repeater',
                    'layout'       => 'table',
                    'instructions' => __('Меняйте процент без перепубликации страниц — значения тянутся из этого списка.', 'qazaqstan'),
                    'button_label' => __('Добавить скидку', 'qazaqstan'),
                    'sub_fields'   => [
                        [
                            'key'   => 'field_discount_label',
                            'label' => __('Категория', 'qazaqstan'),
                            'name'  => 'label',
                            'type'  => 'text',
                        ],
                        [
                            'key'   => 'field_discount_percent',
                            'label' => __('%', 'qazaqstan'),
                            'name'  => 'percent',
                            'type'  => 'number',
                            'min'   => 0,
                            'max'   => 100,
                        ],
                        [
                            'key'   => 'field_discount_note',
                            'label' => __('Примечание', 'qazaqstan'),
                            'name'  => 'note',
                            'type'  => 'text',
                        ],
                    ],
                ],
                [
                    'key'      => 'field_package_includes',
                    'label'    => __('Что входит в путёвку', 'qazaqstan'),
                    'name'     => 'package_includes',
                    'type'     => 'repeater',
                    'layout'   => 'table',
                    'button_label' => __('Добавить пункт', 'qazaqstan'),
                    'sub_fields' => [
                        [
                            'key'   => 'field_package_item',
                            'label' => __('Услуга / пункт', 'qazaqstan'),
                            'name'  => 'item',
                            'type'  => 'text',
                        ],
                    ],
                ],
            ],
        ]);

        acf_add_local_field_group([
            'key'      => 'group_social_options',
            'title'    => __('Соцсети и аналитика', 'qazaqstan'),
            'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'qazaqstan-social']]],
            'fields'   => [
                [
                    'key'      => 'field_socials',
                    'label'    => __('Социальные сети', 'qazaqstan'),
                    'name'     => 'socials',
                    'type'     => 'repeater',
                    'layout'   => 'table',
                    'button_label' => __('Добавить соцсеть', 'qazaqstan'),
                    'sub_fields' => [
                        [
                            'key'     => 'field_social_type',
                            'label'   => __('Платформа', 'qazaqstan'),
                            'name'    => 'type',
                            'type'    => 'select',
                            'choices' => [
                                'instagram' => 'Instagram',
                                'telegram'  => 'Telegram',
                                'whatsapp'  => 'WhatsApp',
                                'facebook'  => 'Facebook',
                                'youtube'   => 'YouTube',
                                'vk'        => 'VK',
                            ],
                        ],
                        [
                            'key'   => 'field_social_url',
                            'label' => __('Ссылка / номер', 'qazaqstan'),
                            'name'  => 'url',
                            'type'  => 'text',
                        ],
                    ],
                ],
                [
                    'key'   => 'field_gtm_id',
                    'label' => __('Google Tag Manager ID', 'qazaqstan'),
                    'name'  => 'gtm_id',
                    'type'  => 'text',
                    'placeholder' => 'GTM-XXXXXXX',
                ],
                [
                    'key'   => 'field_ga4_id',
                    'label' => __('GA4 Measurement ID', 'qazaqstan'),
                    'name'  => 'ga4_id',
                    'type'  => 'text',
                    'placeholder' => 'G-XXXXXXXXXX',
                ],
                [
                    'key'   => 'field_metrika_id',
                    'label' => __('Яндекс.Метрика ID', 'qazaqstan'),
                    'name'  => 'metrika_id',
                    'type'  => 'text',
                ],
            ],
        ]);
    }
}
