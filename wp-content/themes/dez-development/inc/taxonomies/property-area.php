<?php

add_action('init', function (): void {
    $labels = [
        'name'              => _x('Communities', 'Taxonomy General Name', 'codelibry'),
        'singular_name'     => _x('Community', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'         => __('Communities', 'codelibry'),
        'all_items'         => __('All Communities', 'codelibry'),
        'new_item_name'     => __('New Communities Name', 'codelibry'),
        'add_new_item'      => __('Add New Community', 'codelibry'),
        'edit_item'         => __('Edit Community', 'codelibry'),
        'update_item'       => __('Update Community', 'codelibry'),
        'search_items'      => __('Search Communities', 'codelibry'),
        'not_found'         => __('Not Found', 'codelibry'),
        'no_terms'          => __('No Communities', 'codelibry'),
        'items_list'        => __('Communities list', 'codelibry'),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'property-area'],
    ];

    register_taxonomy('property-area', ['property'], $args);
});
