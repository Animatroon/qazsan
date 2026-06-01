<?php

namespace App\Fields;

class BookingRequestFields
{
    public static function register(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key'      => 'group_booking_request',
            'title'    => __('Данные заявки', 'qazaqstan'),
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'booking_request']]],
            'position' => 'normal',
            'fields'   => [
                [
                    'key'   => 'field_br_checkin',
                    'label' => __('Дата заезда', 'qazaqstan'),
                    'name'  => 'br_checkin',
                    'type'  => 'date_picker',
                    'display_format' => 'd.m.Y',
                    'return_format'  => 'Y-m-d',
                ],
                [
                    'key'   => 'field_br_checkout',
                    'label' => __('Дата выезда', 'qazaqstan'),
                    'name'  => 'br_checkout',
                    'type'  => 'date_picker',
                    'display_format' => 'd.m.Y',
                    'return_format'  => 'Y-m-d',
                ],
                [
                    'key'   => 'field_br_room_type',
                    'label' => __('Тип номера', 'qazaqstan'),
                    'name'  => 'br_room_type',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_br_guests',
                    'label' => __('Количество гостей', 'qazaqstan'),
                    'name'  => 'br_guests',
                    'type'  => 'number',
                    'min'   => 1,
                ],
                [
                    'key'   => 'field_br_name',
                    'label' => __('ФИО', 'qazaqstan'),
                    'name'  => 'br_name',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_br_phone',
                    'label' => __('Телефон', 'qazaqstan'),
                    'name'  => 'br_phone',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_br_email',
                    'label' => __('Email', 'qazaqstan'),
                    'name'  => 'br_email',
                    'type'  => 'email',
                ],
                [
                    'key'   => 'field_br_comment',
                    'label' => __('Комментарий', 'qazaqstan'),
                    'name'  => 'br_comment',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
                [
                    'key'          => 'field_br_status',
                    'label'        => __('Статус', 'qazaqstan'),
                    'name'         => 'br_status',
                    'type'         => 'select',
                    'choices'      => [
                        'new'        => __('Новая', 'qazaqstan'),
                        'processing' => __('В работе', 'qazaqstan'),
                        'confirmed'  => __('Подтверждена', 'qazaqstan'),
                        'cancelled'  => __('Отменена', 'qazaqstan'),
                    ],
                    'default_value' => 'new',
                    'ui'           => 1,
                ],
            ],
        ]);
    }
}
