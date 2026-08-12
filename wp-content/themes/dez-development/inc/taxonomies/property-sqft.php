<?php

add_action('init', function (): void {
    $labels = [
        'name'          => _x('Sq Ft Range', 'Taxonomy General Name', 'codelibry'),
        'singular_name' => _x('Sq Ft Range', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'     => __('Sq Ft', 'codelibry'),
        'all_items'     => __('All Sq Ft Ranges', 'codelibry'),
        'add_new_item'  => __('Add Sq Ft Range', 'codelibry'),
        'edit_item'     => __('Edit Sq Ft Range', 'codelibry'),
        'search_items'  => __('Search Sq Ft', 'codelibry'),
        'not_found'     => __('Not Found', 'codelibry'),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'property-sqft'],
    ];

    register_taxonomy('property-sqft', ['property'], $args);
});
