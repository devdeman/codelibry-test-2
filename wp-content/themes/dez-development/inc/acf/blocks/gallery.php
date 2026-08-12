<?php

function codelibry_acf_fields_gallery(): array
{
    return [
        [
            'label'   => 'Label',
            'name'    => 'gallery-label',
            'type'    => 'text',
            'wrapper' => ['width' => '50'],
        ],
        [
            'label'   => 'Title',
            'name'    => 'gallery-title',
            'type'    => 'text',
            'wrapper' => ['width' => '50'],
        ],
        [
            'label'         => 'Items per page',
            'name'          => 'gallery-per-page',
            'type'          => 'number',
            'default_value' => 7,
            'min'           => 4,
            'max'           => 48,
            'instructions'  => 'Number of photos shown initially and loaded on each "Load More" click.',
            'wrapper'       => ['width' => '50'],
        ],
    ];
}
