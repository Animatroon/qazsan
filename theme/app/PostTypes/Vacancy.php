<?php

namespace App\PostTypes;

class Vacancy
{
    public static function register(): void
    {
        register_post_type('vacancy', [
            'labels' => [
                'name'          => __('Вакансии', 'qazaqstan'),
                'singular_name' => __('Вакансия', 'qazaqstan'),
                'add_new_item'  => __('Добавить вакансию', 'qazaqstan'),
                'edit_item'     => __('Редактировать вакансию', 'qazaqstan'),
                'menu_name'     => __('Вакансии', 'qazaqstan'),
            ],
            'public'           => true,
            'has_archive'      => true,
            'show_in_rest'     => true,
            'menu_icon'        => 'dashicons-businessman',
            'menu_position'    => 10,
            'supports'         => ['title', 'editor', 'excerpt'],
            'rewrite'          => ['slug' => 'vacancies', 'with_front' => false],
        ]);
    }
}
