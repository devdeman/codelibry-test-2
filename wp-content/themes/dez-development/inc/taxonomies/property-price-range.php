<?php

add_action('init', function (): void {
    $labels = [
        'name'          => _x('Price Range', 'Taxonomy General Name', 'codelibry'),
        'singular_name' => _x('Price Range', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'     => __('Price Range', 'codelibry'),
        'all_items'     => __('All Price Ranges', 'codelibry'),
        'add_new_item'  => __('Add Price Range', 'codelibry'),
        'edit_item'     => __('Edit Price Range', 'codelibry'),
        'search_items'  => __('Search Price Ranges', 'codelibry'),
        'not_found'     => __('Not Found', 'codelibry'),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'property-price-range'],
    ];

    register_taxonomy('property-price-range', ['property'], $args);
});
