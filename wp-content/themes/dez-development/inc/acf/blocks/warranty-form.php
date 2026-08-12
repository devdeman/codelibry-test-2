<?php

function codelibry_acf_fields_warranty_form(): array
{
    return [
        [
            'label'    => 'Label',
            'name'     => 'warranty-form-label',
            'type'     => 'text',
            'required' => 0,
            'wrapper'  => ['width' => '50'],
        ],
        [
            'label'    => 'Title',
            'name'     => 'warranty-form-title',
            'type'     => 'text',
            'required' => 0,
            'wrapper'  => ['width' => '50'],
        ],
        [
            'label'         => 'Form',
            'name'          => 'warranty-form-form',
            'type'          => 'post_object',
            'post_type'     => ['wpcf7_contact_form'],
            'return_format' => 'id',
            'multiple'      => 0,
            'allow_null'    => 1,
            'ui'            => 1,
            'required'      => 0,
        ],
    ];
}
