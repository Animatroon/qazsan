<?php

namespace App\Taxonomies;

class RoomType
{
    public static function register(): void
    {
        register_taxonomy('room_type', ['room'], [
            'labels' => [
                'name'          => __('Типы номеров', 'qazaqstan'),
                'singular_name' => __('Тип номера', 'qazaqstan'),
                'add_new_item'  => __('Добавить тип', 'qazaqstan'),
                'edit_item'     => __('Редактировать тип', 'qazaqstan'),
                'menu_name'     => __('Типы номеров', 'qazaqstan'),
            ],
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => ['slug' => 'room-type'],
        ]);
    }
}
