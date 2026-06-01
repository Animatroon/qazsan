<?php

namespace App\Fields;

class DoctorFields
{
    public static function register(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key'      => 'group_doctor',
            'title'    => __('Данные врача', 'qazaqstan'),
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'doctor']]],
            'position' => 'normal',
            'fields'   => [
                [
                    'key'   => 'field_doctor_position',
                    'label' => __('Должность', 'qazaqstan'),
                    'name'  => 'doctor_position',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_doctor_experience',
                    'label' => __('Стаж (лет)', 'qazaqstan'),
                    'name'  => 'doctor_experience',
                    'type'  => 'number',
                    'min'   => 0,
                ],
                [
                    'key'      => 'field_doctor_credentials',
                    'label'    => __('Регалии и образование', 'qazaqstan'),
                    'name'     => 'doctor_credentials',
                    'type'     => 'repeater',
                    'layout'   => 'table',
                    'button_label' => __('Добавить регалию', 'qazaqstan'),
                    'sub_fields' => [
                        [
                            'key'   => 'field_doctor_credential_item',
                            'label' => __('Регалия', 'qazaqstan'),
                            'name'  => 'item',
                            'type'  => 'text',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
