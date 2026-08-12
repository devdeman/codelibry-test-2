<?php

add_action('init', function (): void {
    $labels = [
        'name'          => _x('Cities (Property)', 'Taxonomy General Name', 'codelibry'),
        'singular_name' => _x('City', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'     => __('Cities', 'codelibry'),
        'all_items'     => __('All Cities', 'codelibry'),
        'add_new_item'  => __('Add New City', 'codelibry'),
        'edit_item'     => __('Edit City', 'codelibry'),
        'search_items'  => __('Search Cities', 'codelibry'),
        'not_found'     => __('Not Found', 'codelibry'),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'property-city'],
    ];

    register_taxonomy('property-city', ['property'], $args);
});
