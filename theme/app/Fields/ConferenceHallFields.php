<?php

namespace App\Fields;

class ConferenceHallFields
{
    public static function register(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key'      => 'group_conference_hall',
            'title'    => __('Параметры зала', 'qazaqstan'),
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'conference_hall']]],
            'position' => 'normal',
            'fields'   => [
                [
                    'key'   => 'field_hall_area',
                    'label' => __('Площадь (м²)', 'qazaqstan'),
                    'name'  => 'hall_area',
                    'type'  => 'number',
                    'min'   => 1,
                ],
                [
                    'key'   => 'field_hall_capacity',
                    'label' => __('Вместимость (чел.)', 'qazaqstan'),
                    'name'  => 'hall_capacity',
                    'type'  => 'number',
                    'min'   => 1,
                ],
                [
                    'key'          => 'field_hall_price_hour',
                    'label'        => __('Аренда в час (₸)', 'qazaqstan'),
                    'name'         => 'hall_price_hour',
                    'type'         => 'number',
                    'min'          => 0,
                    'instructions' => __('0 — цена по запросу', 'qazaqstan'),
                ],
                [
                    'key'   => 'field_hall_price_day',
                    'label' => __('Аренда в день (₸)', 'qazaqstan'),
                    'name'  => 'hall_price_day',
                    'type'  => 'number',
                    'min'   => 0,
                ],
                [
                    'key'      => 'field_hall_equipment',
                    'label'    => __('Оснащение', 'qazaqstan'),
                    'name'     => 'hall_equipment',
                    'type'     => 'repeater',
                    'layout'   => 'table',
                    'button_label' => __('Добавить пункт', 'qazaqstan'),
                    'sub_fields' => [
                        [
                            'key'   => 'field_hall_equip_item',
                            'label' => __('Оборудование', 'qazaqstan'),
                            'name'  => 'item',
                            'type'  => 'text',
                        ],
                    ],
                ],
                [
                    'key'          => 'field_hall_gallery',
                    'label'        => __('Галерея зала', 'qazaqstan'),
                    'name'         => 'hall_gallery',
                    'type'         => 'gallery',
                    'preview_size' => 'medium',
                    'mime_types'   => 'jpg,jpeg,png,webp',
                ],
                [
                    'key'          => 'field_hall_layout_image',
                    'label'        => __('Планировка (изображение)', 'qazaqstan'),
                    'name'         => 'hall_layout_image',
                    'type'         => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                ],
            ],
        ]);
    }
}
