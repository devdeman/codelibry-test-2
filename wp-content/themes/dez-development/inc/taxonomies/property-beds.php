<?php

add_action('init', function (): void {
    $labels = [
        'name'          => _x('Beds', 'Taxonomy General Name', 'codelibry'),
        'singular_name' => _x('Beds', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'     => __('Beds', 'codelibry'),
        'all_items'     => __('All Bed Counts', 'codelibry'),
        'add_new_item'  => __('Add Bed Count', 'codelibry'),
        'edit_item'     => __('Edit Bed Count', 'codelibry'),
        'search_items'  => __('Search Beds', 'codelibry'),
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
        'rewrite'           => ['slug' => 'property-beds'],
    ];

    register_taxonomy('property-beds', ['property'], $args);
});
