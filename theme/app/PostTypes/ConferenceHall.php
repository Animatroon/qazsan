<?php

namespace App\PostTypes;

class ConferenceHall
{
    public static function register(): void
    {
        register_post_type('conference_hall', [
            'labels' => [
                'name'          => __('Конференц-залы', 'qazaqstan'),
                'singular_name' => __('Конференц-зал', 'qazaqstan'),
                'add_new_item'  => __('Добавить зал', 'qazaqstan'),
                'edit_item'     => __('Редактировать зал', 'qazaqstan'),
                'menu_name'     => __('Конференц-залы', 'qazaqstan'),
            ],
            'public'           => true,
            'has_archive'      => false,
            'show_in_rest'     => true,
            'menu_icon'        => 'dashicons-groups',
            'menu_position'    => 8,
            'supports'         => ['title', 'editor', 'thumbnail', 'excerpt'],
            'rewrite'          => ['slug' => 'conferences', 'with_front' => false],
        ]);
    }
}
