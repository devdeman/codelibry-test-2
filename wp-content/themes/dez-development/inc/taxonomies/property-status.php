<?php

add_action('init', function (): void {
    $labels = [
        'name'          => _x('Statuses (Property)', 'Taxonomy General Name', 'codelibry'),
        'singular_name' => _x('Status', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'     => __('Statuses', 'codelibry'),
        'all_items'     => __('All Statuses', 'codelibry'),
        'add_new_item'  => __('Add Status', 'codelibry'),
        'edit_item'     => __('Edit Status', 'codelibry'),
        'search_items'  => __('Search Statuses', 'codelibry'),
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
        'rewrite'           => ['slug' => 'property-status'],
    ];

    register_taxonomy('property-status', ['property'], $args);
});

add_action('init', function (): void {
    $default_terms = ['Active'];
    foreach ($default_terms as $term) {
        if (!term_exists($term, 'property-status')) {
            wp_insert_term($term, 'property-status');
        }
    }
}, 20);
