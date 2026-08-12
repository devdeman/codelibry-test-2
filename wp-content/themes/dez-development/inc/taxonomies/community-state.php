<?php

add_action('init', function (): void {
    $labels = [
        'name'          => _x('States', 'Taxonomy General Name', 'codelibry'),
        'singular_name' => _x('State', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'     => __('States', 'codelibry'),
        'all_items'     => __('All States', 'codelibry'),
        'add_new_item'  => __('Add State', 'codelibry'),
        'edit_item'     => __('Edit State', 'codelibry'),
        'search_items'  => __('Search States', 'codelibry'),
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
        'rewrite'           => ['slug' => 'community-state'],
    ];

    register_taxonomy('community-state', ['communities'], $args);
});
