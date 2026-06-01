<?php

namespace App\PostTypes;

class Room
{
    public static function register(): void
    {
        register_post_type('room', [
            'labels' => [
                'name'               => __('Номера', 'qazaqstan'),
                'singular_name'      => __('Номер', 'qazaqstan'),
                'add_new_item'       => __('Добавить номер', 'qazaqstan'),
                'edit_item'          => __('Редактировать номер', 'qazaqstan'),
                'view_item'          => __('Просмотреть номер', 'qazaqstan'),
                'search_items'       => __('Найти номера', 'qazaqstan'),
                'not_found'          => __('Номера не найдены', 'qazaqstan'),
                'menu_name'          => __('Номера', 'qazaqstan'),
            ],
            'public'             => true,
            'has_archive'        => true,
            'show_in_rest'       => true,
            'menu_icon'          => 'dashicons-building',
            'menu_position'      => 5,
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
            'rewrite'            => ['slug' => 'accommodation', 'with_front' => false],
            'show_in_nav_menus'  => true,
        ]);
    }
}
