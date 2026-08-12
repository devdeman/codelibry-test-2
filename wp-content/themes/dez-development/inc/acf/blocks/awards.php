<?php

function codelibry_acf_fields_awards(): array
{
    return [
        [
            'label'   => 'Label',
            'name'    => 'awards-label',
            'type'    => 'text',
            'required' => 0,
            'wrapper' => ['width' => '50'],
        ],
        [
            'label'   => 'Title',
            'name'    => 'awards-title',
            'type'    => 'text',
            'required' => 0,
            'wrapper' => ['width' => '50'],
        ],
        [
            'label'         => 'Awards',
            'name'          => 'awards-posts',
            'type'          => 'post_object',
            'post_type'     => ['award'],
            'return_format' => 'id',
            'multiple'      => 1,
            'allow_null'    => 1,
            'ui'            => 1,
            'required'      => 0,
        ],
    ];
}
