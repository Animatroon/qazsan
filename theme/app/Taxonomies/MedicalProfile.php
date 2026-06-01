<?php

namespace App\Taxonomies;

class MedicalProfile
{
    public static function register(): void
    {
        register_taxonomy('medical_profile', ['doctor', 'procedure'], [
            'labels' => [
                'name'          => __('Профили лечения', 'qazaqstan'),
                'singular_name' => __('Профиль лечения', 'qazaqstan'),
                'add_new_item'  => __('Добавить профиль', 'qazaqstan'),
                'edit_item'     => __('Редактировать профиль', 'qazaqstan'),
                'menu_name'     => __('Профили лечения', 'qazaqstan'),
            ],
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => ['slug' => 'medical-profile'],
        ]);
    }
}
