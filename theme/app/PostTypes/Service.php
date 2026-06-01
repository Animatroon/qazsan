<?php

namespace App\PostTypes;

class Service
{
    public static function register(): void
    {
        register_post_type('service', [
            'labels' => [
                'name'          => __('Услуги', 'qazaqstan'),
                'singular_name' => __('Услуга', 'qazaqstan'),
                'add_new_item'  => __('Добавить услугу', 'qazaqstan'),
                'edit_item'     => __('Редактировать услугу', 'qazaqstan'),
                'menu_name'     => __('Услуги', 'qazaqstan'),
            ],
            'public'           => true,
            'has_archive'      => true,
            'show_in_rest'     => true,
            'menu_icon'        => 'dashicons-star-filled',
            'menu_position'    => 9,
            'supports'         => ['title', 'editor', 'thumbnail', 'excerpt'],
            'rewrite'          => ['slug' => 'services', 'with_front' => false],
        ]);
    }
}
