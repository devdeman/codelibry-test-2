<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page([
            'page_title'  => 'Properties Archive',
            'menu_title'  => 'Properties Archive',
            'menu_slug'   => 'theme-options-properties-archive',
            'parent_slug' => 'theme-options',
            'capability'  => 'edit_theme_options',
        ]);
    }

    ACFComposer::registerFieldGroup([
        'name'   => 'properties_archive_options',
        'title'  => 'Properties Archive Options',
        'fields' => [
            [
                'label'         => 'Hero Image',
                'name'          => 'prop-hero-image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
            ],
            [
                'label'   => 'Hero Label',
                'name'    => 'prop-hero-label',
                'type'    => 'text',
                'wrapper' => ['width' => '50'],
            ],
            [
                'label'   => 'Hero Title',
                'name'    => 'prop-hero-title',
                'type'    => 'text',
                'wrapper' => ['width' => '50'],
            ],
            [
                'label' => 'Hero Text',
                'name'  => 'prop-hero-text',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'theme-options-properties-archive',
                ],
            ],
        ],
    ]);
});
