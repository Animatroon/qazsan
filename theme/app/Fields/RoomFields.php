<?php

namespace App\Fields;

class RoomFields
{
    public static function register(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key'      => 'group_room',
            'title'    => __('Параметры номера', 'qazaqstan'),
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'room']]],
            'position' => 'normal',
            'fields'   => [
                [
                    'key'   => 'field_room_area',
                    'label' => __('Площадь (м²)', 'qazaqstan'),
                    'name'  => 'room_area',
                    'type'  => 'number',
                    'min'   => 1,
                ],
                [
                    'key'   => 'field_room_capacity',
                    'label' => __('Вместимость (чел.)', 'qazaqstan'),
                    'name'  => 'room_capacity',
                    'type'  => 'number',
                    'min'   => 1,
                ],
                [
                    'key'            => 'field_room_price_single',
                    'label'          => __('Цена 1-местного (₸/сут)', 'qazaqstan'),
                    'name'           => 'room_price_single',
                    'type'           => 'number',
                    'min'            => 0,
                    'instructions'   => __('Например: 32000', 'qazaqstan'),
                ],
                [
                    'key'          => 'field_room_price_double',
                    'label'        => __('Цена 2-местного (₸/сут)', 'qazaqstan'),
                    'name'         => 'room_price_double',
                    'type'         => 'number',
                    'min'          => 0,
                    'instructions' => __('Например: 56000', 'qazaqstan'),
                ],
                [
                    'key'     => 'field_room_bookable',
                    'label'   => __('Доступен для бронирования', 'qazaqstan'),
                    'name'    => 'room_bookable',
                    'type'    => 'true_false',
                    'default' => 1,
                    'ui'      => 1,
                ],
                [
                    'key'          => 'field_room_gallery',
                    'label'        => __('Галерея номера', 'qazaqstan'),
                    'name'         => 'room_gallery',
                    'type'         => 'gallery',
                    'instructions' => __('Минимум 3 фото. Первое фото — обложка.', 'qazaqstan'),
                    'min'          => 1,
                    'preview_size' => 'medium',
                    'mime_types'   => 'jpg,jpeg,png,webp',
                ],
                [
                    'key'      => 'field_room_includes',
                    'label'    => __('Что включено', 'qazaqstan'),
                    'name'     => 'room_includes',
                    'type'     => 'repeater',
                    'layout'   => 'table',
                    'button_label' => __('Добавить пункт', 'qazaqstan'),
                    'sub_fields' => [
                        [
                            'key'   => 'field_room_includes_item',
                            'label' => __('Пункт', 'qazaqstan'),
                            'name'  => 'item',
                            'type'  => 'text',
                        ],
                    ],
                ],
                [
                    'key'   => 'field_room_floor',
                    'label' => __('Этаж', 'qazaqstan'),
                    'name'  => 'room_floor',
                    'type'  => 'number',
                    'min'   => 1,
                ],
            ],
        ]);
    }
}
