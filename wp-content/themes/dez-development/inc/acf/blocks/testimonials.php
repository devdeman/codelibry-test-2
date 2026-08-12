<?php

function codelibry_acf_fields_testimonials(): array
{
    return [
        [
            'label'    => 'Label',
            'name'     => 'testimonials-label',
            'type'     => 'text',
            'required' => 0,
            'wrapper'  => ['width' => '50'],
        ],
        [
            'label'    => 'Title',
            'name'     => 'testimonials-title',
            'type'     => 'text',
            'required' => 0,
            'wrapper'  => ['width' => '50'],
        ],
        [
            'label'         => 'Reviews',
            'name'          => 'testimonials-posts',
            'type'          => 'post_object',
            'post_type'     => ['testimonials'],
            'return_format' => 'id',
            'multiple'      => 1,
            'allow_null'    => 1,
            'ui'            => 1,
            'required'      => 0,
        ],
    ];
}
