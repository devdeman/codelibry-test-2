<?php

add_action('init', function (): void {
    $labels = [
        'name'                       => _x('School Districts', 'Taxonomy General Name', 'codelibry'),
        'singular_name'              => _x('School District', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'                  => __('School Districts', 'codelibry'),
        'all_items'                  => __('All School Districts', 'codelibry'),
        'parent_item'                => __('Parent District', 'codelibry'),
        'parent_item_colon'          => __('Parent District:', 'codelibry'),
        'new_item_name'              => __('New District Name', 'codelibry'),
        'add_new_item'               => __('Add New District', 'codelibry'),
        'edit_item'                  => __('Edit District', 'codelibry'),
        'update_item'                => __('Update District', 'codelibry'),
        'view_item'                  => __('View District', 'codelibry'),
        'separate_items_with_commas' => __('Separate Districts with commas', 'codelibry'),
        'add_or_remove_items'        => __('Add or remove Districts', 'codelibry'),
        'choose_from_most_used'      => __('Choose from the most used', 'codelibry'),
        'popular_items'              => __('Popular Districts', 'codelibry'),
        'search_items'               => __('Search Districts', 'codelibry'),
        'not_found'                  => __('Not Found', 'codelibry'),
        'no_terms'                   => __('No Districts', 'codelibry'),
        'items_list'                 => __('Districts list', 'codelibry'),
        'items_list_navigation'      => __('Districts list navigation', 'codelibry'),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'schools'],
    ];

    register_taxonomy('community-schools', ['communities'], $args);
});
