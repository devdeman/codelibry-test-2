<?php

add_action('init', function (): void {
    $labels = [
        'name'          => _x('Garage', 'Taxonomy General Name', 'codelibry'),
        'singular_name' => _x('Garage', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'     => __('Garage', 'codelibry'),
        'all_items'     => __('All Garage Options', 'codelibry'),
        'add_new_item'  => __('Add Garage Option', 'codelibry'),
        'edit_item'     => __('Edit Garage Option', 'codelibry'),
        'search_items'  => __('Search Garage', 'codelibry'),
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
        'rewrite'           => ['slug' => 'property-garage'],
    ];

    register_taxonomy('property-garage', ['property'], $args);
});
