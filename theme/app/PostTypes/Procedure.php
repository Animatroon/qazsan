<?php

namespace App\PostTypes;

class Procedure
{
    public static function register(): void
    {
        register_post_type('procedure', [
            'labels' => [
                'name'          => __('Процедуры', 'qazaqstan'),
                'singular_name' => __('Процедура', 'qazaqstan'),
                'add_new_item'  => __('Добавить процедуру', 'qazaqstan'),
                'edit_item'     => __('Редактировать процедуру', 'qazaqstan'),
                'menu_name'     => __('Процедуры', 'qazaqstan'),
            ],
            'public'           => true,
            'has_archive'      => false,
            'show_in_rest'     => true,
            'menu_icon'        => 'dashicons-heart',
            'menu_position'    => 7,
            'supports'         => ['title', 'editor', 'thumbnail', 'excerpt'],
            'rewrite'          => ['slug' => 'treatment', 'with_front' => false],
        ]);
    }
}
