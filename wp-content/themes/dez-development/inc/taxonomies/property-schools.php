<?php

add_action('init', function (): void {
    $labels = [
        'name'          => _x('Schools (Property)', 'Taxonomy General Name', 'codelibry'),
        'singular_name' => _x('School', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'     => __('Schools', 'codelibry'),
        'all_items'     => __('All Schools', 'codelibry'),
        'add_new_item'  => __('Add School', 'codelibry'),
        'edit_item'     => __('Edit School', 'codelibry'),
        'search_items'  => __('Search Schools', 'codelibry'),
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
        'rewrite'           => ['slug' => 'property-schools'],
    ];

    register_taxonomy('property-schools', ['property'], $args);
});
