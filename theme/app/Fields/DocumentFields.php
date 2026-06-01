<?php

namespace App\Fields;

class DocumentFields
{
    public static function register(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key'      => 'group_document',
            'title'    => __('Параметры документа', 'qazaqstan'),
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'document']]],
            'position' => 'normal',
            'fields'   => [
                [
                    'key'          => 'field_document_file',
                    'label'        => __('Файл (PDF)', 'qazaqstan'),
                    'name'         => 'document_file',
                    'type'         => 'file',
                    'required'     => 1,
                    'mime_types'   => 'pdf',
                    'return_format' => 'array',
                ],
                [
                    'key'      => 'field_document_year',
                    'label'    => __('Год', 'qazaqstan'),
                    'name'     => 'document_year',
                    'type'     => 'number',
                    'min'      => 2000,
                    'max'      => 2099,
                    'default_value' => (int) date('Y'),
                ],
                [
                    'key'   => 'field_document_number',
                    'label' => __('Номер / реквизит документа', 'qazaqstan'),
                    'name'  => 'document_number',
                    'type'  => 'text',
                ],
            ],
        ]);
    }
}
