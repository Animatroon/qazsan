<?php

namespace App\PostTypes;

class Testimonial
{
    public static function register(): void
    {
        register_post_type('testimonial', [
            'labels' => [
                'name'          => __('Отзывы', 'qazaqstan'),
                'singular_name' => __('Отзыв', 'qazaqstan'),
                'add_new_item'  => __('Добавить отзыв', 'qazaqstan'),
                'edit_item'     => __('Редактировать отзыв', 'qazaqstan'),
                'menu_name'     => __('Отзывы', 'qazaqstan'),
            ],
            'public'           => false,
            'show_ui'          => true,
            'show_in_rest'     => true,
            'menu_icon'        => 'dashicons-format-quote',
            'menu_position'    => 12,
            'supports'         => ['title', 'editor', 'thumbnail'],
        ]);
    }
}
