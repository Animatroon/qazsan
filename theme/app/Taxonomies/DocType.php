<?php

namespace App\Taxonomies;

class DocType
{
    public static function register(): void
    {
        register_taxonomy('doc_type', ['document'], [
            'labels' => [
                'name'          => __('Типы документов', 'qazaqstan'),
                'singular_name' => __('Тип документа', 'qazaqstan'),
                'add_new_item'  => __('Добавить тип', 'qazaqstan'),
                'edit_item'     => __('Редактировать тип', 'qazaqstan'),
                'menu_name'     => __('Типы документов', 'qazaqstan'),
            ],
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => ['slug' => 'doc-type'],
        ]);
    }
}
