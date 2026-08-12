<?php

add_action('init', function (): void {
    $labels = [
        'name'                       => _x('Areas', 'Taxonomy General Name', 'codelibry'),
        'singular_name'              => _x('Area', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'                  => __('Areas', 'codelibry'),
        'all_items'                  => __('All Areas', 'codelibry'),
        'parent_item'                => __('Parent Area', 'codelibry'),
        'parent_item_colon'          => __('Parent Area:', 'codelibry'),
        'new_item_name'              => __('New Area Name', 'codelibry'),
        'add_new_item'               => __('Add New Area', 'codelibry'),
        'edit_item'                  => __('Edit Area', 'codelibry'),
        'update_item'                => __('Update Area', 'codelibry'),
        'view_item'                  => __('View Area', 'codelibry'),
        'separate_items_with_commas' => __('Separate Areas with commas', 'codelibry'),
        'add_or_remove_items'        => __('Add or remove Areas', 'codelibry'),
        'choose_from_most_used'      => __('Choose from the most used', 'codelibry'),
        'popular_items'              => __('Popular Areas', 'codelibry'),
        'search_items'               => __('Search Areas', 'codelibry'),
        'not_found'                  => __('Not Found', 'codelibry'),
        'no_terms'                   => __('No Areas', 'codelibry'),
        'items_list'                 => __('Areas list', 'codelibry'),
        'items_list_navigation'      => __('Areas list navigation', 'codelibry'),
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
        'rewrite'           => ['slug' => 'area'],
    ];

    register_taxonomy('community-area', ['communities'], $args);
});
