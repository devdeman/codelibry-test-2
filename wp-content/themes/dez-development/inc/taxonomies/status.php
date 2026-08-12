<?php

add_action('init', function (): void {
    $labels = [
        'name'                       => _x('Statuses', 'Taxonomy General Name', 'codelibry'),
        'singular_name'              => _x('Status', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'                  => __('Statuses', 'codelibry'),
        'all_items'                  => __('All Statuses', 'codelibry'),
        'new_item_name'              => __('New Status Name', 'codelibry'),
        'add_new_item'               => __('Add New Status', 'codelibry'),
        'edit_item'                  => __('Edit Status', 'codelibry'),
        'update_item'                => __('Update Status', 'codelibry'),
        'search_items'               => __('Search Statuses', 'codelibry'),
        'not_found'                  => __('Not Found', 'codelibry'),
        'no_terms'                   => __('No Statuses', 'codelibry'),
        'items_list'                 => __('Statuses list', 'codelibry'),
        'items_list_navigation'      => __('Statuses list navigation', 'codelibry'),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'community-status'],
    ];

    register_taxonomy('community-status', ['communities'], $args);
});

add_action('init', function (): void {
    $default_terms = ['Models Now Open', 'Coming Soon'];

    foreach ($default_terms as $term) {
        if (!term_exists($term, 'community-status')) {
            wp_insert_term($term, 'community-status');
        }
    }
}, 20);
