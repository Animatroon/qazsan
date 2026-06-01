<?php

namespace App\PostTypes;

class BookingRequest
{
    public static function register(): void
    {
        register_post_type('booking_request', [
            'labels' => [
                'name'          => __('Заявки на бронь', 'qazaqstan'),
                'singular_name' => __('Заявка', 'qazaqstan'),
                'edit_item'     => __('Просмотреть заявку', 'qazaqstan'),
                'menu_name'     => __('Заявки', 'qazaqstan'),
            ],
            'public'           => false,
            'show_ui'          => true,
            'show_in_rest'     => false,
            'menu_icon'        => 'dashicons-calendar-alt',
            'menu_position'    => 2,
            'supports'         => ['title'],
            'capability_type'  => 'post',
            'capabilities'     => ['create_posts' => 'do_not_allow'],
            'map_meta_cap'     => true,
        ]);
    }
}
