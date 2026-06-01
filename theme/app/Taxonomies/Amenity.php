<?php

namespace App\Taxonomies;

class Amenity
{
    public static function register(): void
    {
        register_taxonomy('amenity', ['room'], [
            'labels' => [
                'name'          => __('Удобства', 'qazaqstan'),
                'singular_name' => __('Удобство', 'qazaqstan'),
                'add_new_item'  => __('Добавить удобство', 'qazaqstan'),
                'edit_item'     => __('Редактировать удобство', 'qazaqstan'),
                'menu_name'     => __('Удобства', 'qazaqstan'),
            ],
            'public'            => true,
            'hierarchical'      => false,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => ['slug' => 'amenity'],
        ]);
    }
}
