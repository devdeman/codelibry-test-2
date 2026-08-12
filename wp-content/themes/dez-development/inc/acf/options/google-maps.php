<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page([
            'page_title'  => 'Google Maps',
            'menu_title'  => 'Google Maps',
            'menu_slug'   => 'theme-options-google-maps',
            'parent_slug' => 'theme-options',
            'capability'  => 'edit_theme_options',
        ]);
    }

    ACFComposer::registerFieldGroup([
        'name'   => 'google_maps_options',
        'title'  => 'Google Maps API',
        'fields' => [
            [
                'label'         => 'API Key',
                'name'          => 'google_maps_api_key',
                'type'          => 'text',
                'instructions'  => 'Google Maps JavaScript API + Geocoding API key. If empty, uses the default key from code.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'theme-options-google-maps',
                ],
            ],
        ],
    ]);
});

