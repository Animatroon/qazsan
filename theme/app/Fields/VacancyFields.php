<?php

namespace App\Fields;

class VacancyFields
{
    public static function register(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key'      => 'group_vacancy',
            'title'    => __('Параметры вакансии', 'qazaqstan'),
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'vacancy']]],
            'position' => 'normal',
            'fields'   => [
                [
                    'key'   => 'field_vacancy_department',
                    'label' => __('Отдел / подразделение', 'qazaqstan'),
                    'name'  => 'vacancy_department',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_vacancy_salary',
                    'label' => __('Зарплата', 'qazaqstan'),
                    'name'  => 'vacancy_salary',
                    'type'  => 'text',
                    'instructions' => __('Например: от 250 000 ₸ или по договорённости', 'qazaqstan'),
                ],
                [
                    'key'          => 'field_vacancy_status',
                    'label'        => __('Статус', 'qazaqstan'),
                    'name'         => 'vacancy_status',
                    'type'         => 'select',
                    'choices'      => [
                        'open'   => __('Открыта', 'qazaqstan'),
                        'closed' => __('Закрыта', 'qazaqstan'),
                    ],
                    'default_value' => 'open',
                    'ui'           => 1,
                ],
                [
                    'key'          => 'field_vacancy_deadline',
                    'label'        => __('Дата окончания приёма', 'qazaqstan'),
                    'name'         => 'vacancy_deadline',
                    'type'         => 'date_picker',
                    'display_format' => 'd.m.Y',
                    'return_format'  => 'Y-m-d',
                ],
                [
                    'key'      => 'field_vacancy_requirements',
                    'label'    => __('Требования', 'qazaqstan'),
                    'name'     => 'vacancy_requirements',
                    'type'     => 'repeater',
                    'layout'   => 'table',
                    'button_label' => __('Добавить требование', 'qazaqstan'),
                    'sub_fields' => [
                        [
                            'key'   => 'field_vacancy_req_item',
                            'label' => __('Требование', 'qazaqstan'),
                            'name'  => 'item',
                            'type'  => 'text',
                        ],
                    ],
                ],
                [
                    'key'      => 'field_vacancy_duties',
                    'label'    => __('Обязанности', 'qazaqstan'),
                    'name'     => 'vacancy_duties',
                    'type'     => 'repeater',
                    'layout'   => 'table',
                    'button_label' => __('Добавить обязанность', 'qazaqstan'),
                    'sub_fields' => [
                        [
                            'key'   => 'field_vacancy_duty_item',
                            'label' => __('Обязанность', 'qazaqstan'),
                            'name'  => 'item',
                            'type'  => 'text',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
