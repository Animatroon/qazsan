<?php

namespace App\PostTypes;

class Appeal
{
    public static function register(): void
    {
        register_post_type('appeal', [
            'labels' => [
                'name'          => __('Обращения', 'qazaqstan'),
                'singular_name' => __('Обращение', 'qazaqstan'),
                'edit_item'     => __('Просмотреть обращение', 'qazaqstan'),
                'menu_name'     => __('Обращения', 'qazaqstan'),
            ],
            'public'           => false,
            'show_ui'          => true,
            'show_in_rest'     => false,
            'menu_icon'        => 'dashicons-email-alt',
            'menu_position'    => 3,
            'supports'         => ['title'],
            'capability_type'  => 'post',
            'capabilities'     => ['create_posts' => 'do_not_allow'],
            'map_meta_cap'     => true,
        ]);
    }
}
