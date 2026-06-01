<?php

namespace App\PostTypes;

class Doctor
{
    public static function register(): void
    {
        register_post_type('doctor', [
            'labels' => [
                'name'          => __('Врачи', 'qazaqstan'),
                'singular_name' => __('Врач', 'qazaqstan'),
                'add_new_item'  => __('Добавить врача', 'qazaqstan'),
                'edit_item'     => __('Редактировать врача', 'qazaqstan'),
                'menu_name'     => __('Врачи', 'qazaqstan'),
            ],
            'public'            => true,
            'has_archive'       => false,
            'show_in_rest'      => true,
            'menu_icon'         => 'dashicons-universal-access',
            'menu_position'     => 6,
            'supports'          => ['title', 'editor', 'thumbnail'],
            'rewrite'           => ['slug' => 'treatment/doctors', 'with_front' => false],
        ]);
    }
}
