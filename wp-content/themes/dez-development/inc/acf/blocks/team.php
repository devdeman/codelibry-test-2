<?php

function codelibry_acf_fields_team(): array
{
    return [
        [
            'label'   => 'Label',
            'name'    => 'team-label',
            'type'    => 'text',
            'required' => 0,
            'wrapper' => ['width' => '50'],
        ],
        [
            'label'   => 'Title',
            'name'    => 'team-title',
            'type'    => 'text',
            'required' => 0,
            'wrapper' => ['width' => '50'],
        ],
        [
            'label'         => 'Team Members',
            'name'          => 'team-posts',
            'type'          => 'post_object',
            'post_type'     => ['team-member'],
            'return_format' => 'id',
            'multiple'      => 1,
            'allow_null'    => 1,
            'ui'            => 1,
            'required'      => 0,
        ],
    ];
}
