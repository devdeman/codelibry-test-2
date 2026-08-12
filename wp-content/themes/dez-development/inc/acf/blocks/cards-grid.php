<?php

function codelibry_acf_fields_cards_grid(): array
{
    return [
        [
            'label'   => 'Label',
            'name'    => 'cards-grid-label',
            'type'    => 'text',
            'wrapper' => ['width' => '25'],
        ],
        [
            'label'   => 'Title',
            'name'    => 'cards-grid-title',
            'type'    => 'text',
            'wrapper' => ['width' => '25'],
        ],
        [
            'label'         => 'Link',
            'name'          => 'cards-grid-link',
            'type'          => 'link',
            'return_format' => 'array',
            'wrapper'       => ['width' => '25'],
        ],
        [
            'label'         => 'Columns',
            'name'          => 'cards-grid-columns',
            'type'          => 'select',
            'choices'       => ['3' => '3 per row', '4' => '4 per row'],
            'default_value' => '3',
            'allow_null'    => 0,
            'wrapper'       => ['width' => '33'],
        ],
        [
            'label'         => 'Posts',
            'name'          => 'cards-grid-posts',
            'type'          => 'post_object',
            'post_type'     => ['property', 'communities'],
            'return_format' => 'id',
            'multiple'      => 1,
            'allow_null'    => 1,
            'ui'            => 1,
        ],
    ];
}
