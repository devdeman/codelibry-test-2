<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page([
            'page_title'  => 'Placeholders',
            'menu_title'  => 'Placeholders',
            'menu_slug'   => 'theme-options-placeholders',
            'parent_slug' => 'theme-options',
            'capability'  => 'edit_theme_options',
        ]);
    }

    ACFComposer::registerFieldGroup([
        'name'   => 'placeholders_options',
        'title'  => 'Placeholder Images',
        'fields' => [
            [
                'label'         => 'Community Hero Placeholder',
                'name'          => 'community-hero-placeholder',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'instructions'  => 'Shown on community pages when no hero image is set.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'theme-options-placeholders',
                ],
            ],
        ],
    ]);
});
