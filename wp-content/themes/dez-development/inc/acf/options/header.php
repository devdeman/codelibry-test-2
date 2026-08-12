<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page([
            'page_title'  => 'Header',
            'menu_title'  => 'Header',
            'menu_slug'   => 'theme-options-header',
            'parent_slug' => 'theme-options',
            'capability'  => 'edit_theme_options',
        ]);
    }

    ACFComposer::registerFieldGroup([
        'name'   => 'header_options',
        'title'  => 'Header Options',
        'fields' => [
            [
                'label'         => 'CTA Button 1',
                'name'          => 'cta-button-1',
                'type'          => 'link',
                'return_format' => 'array',
            ],
            [
                'label'         => 'CTA Button 2',
                'name'          => 'cta-button-2',
                'type'          => 'link',
                'return_format' => 'array',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'theme-options-header',
                ],
            ],
        ],
    ]);
});
