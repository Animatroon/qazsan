<?php

namespace App\PostTypes;

class Document
{
    public static function register(): void
    {
        register_post_type('document', [
            'labels' => [
                'name'          => __('Документы', 'qazaqstan'),
                'singular_name' => __('Документ', 'qazaqstan'),
                'add_new_item'  => __('Добавить документ', 'qazaqstan'),
                'edit_item'     => __('Редактировать документ', 'qazaqstan'),
                'menu_name'     => __('Документы', 'qazaqstan'),
            ],
            'public'           => true,
            'has_archive'      => false,
            'show_in_rest'     => true,
            'menu_icon'        => 'dashicons-media-document',
            'menu_position'    => 11,
            'supports'         => ['title', 'excerpt'],
            'rewrite'          => ['slug' => 'documents', 'with_front' => false],
        ]);
    }
}
