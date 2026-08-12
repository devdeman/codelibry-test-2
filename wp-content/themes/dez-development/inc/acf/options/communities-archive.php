<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page([
            'page_title'  => 'Communities Archive',
            'menu_title'  => 'Communities Archive',
            'menu_slug'   => 'theme-options-communities-archive',
            'parent_slug' => 'theme-options',
            'capability'  => 'edit_theme_options',
        ]);
    }

    ACFComposer::registerFieldGroup([
        'name'   => 'communities_archive_options',
        'title'  => 'Communities Archive Options',
        'fields' => [
            [
                'label'         => 'Hero Image',
                'name'          => 'hero-image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
            ],
            [
                'label'   => 'Hero Label',
                'name'    => 'hero-label',
                'type'    => 'text',
                'wrapper' => ['width' => '50'],
            ],
            [
                'label'   => 'Hero Title',
                'name'    => 'hero-title',
                'type'    => 'text',
                'wrapper' => ['width' => '50'],
            ],
            [
                'label' => 'Hero Text',
                'name'  => 'hero-text',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'theme-options-communities-archive',
                ],
            ],
        ],
    ]);
});
