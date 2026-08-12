<?php

add_action('init', function (): void {
    $labels = [
        'name'                       => _x('Cities', 'Taxonomy General Name', 'codelibry'),
        'singular_name'              => _x('City', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'                  => __('Cities', 'codelibry'),
        'all_items'                  => __('All Cities', 'codelibry'),
        'parent_item'                => __('Parent City', 'codelibry'),
        'parent_item_colon'          => __('Parent City:', 'codelibry'),
        'new_item_name'              => __('New City Name', 'codelibry'),
        'add_new_item'               => __('Add New City', 'codelibry'),
        'edit_item'                  => __('Edit City', 'codelibry'),
        'update_item'                => __('Update City', 'codelibry'),
        'view_item'                  => __('View City', 'codelibry'),
        'separate_items_with_commas' => __('Separate Cities with commas', 'codelibry'),
        'add_or_remove_items'        => __('Add or remove Cities', 'codelibry'),
        'choose_from_most_used'      => __('Choose from the most used', 'codelibry'),
        'popular_items'              => __('Popular Cities', 'codelibry'),
        'search_items'               => __('Search Cities', 'codelibry'),
        'not_found'                  => __('Not Found', 'codelibry'),
        'no_terms'                   => __('No Cities', 'codelibry'),
        'items_list'                 => __('Cities list', 'codelibry'),
        'items_list_navigation'      => __('Cities list navigation', 'codelibry'),
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
        'rewrite'           => ['slug' => 'city'],
    ];

    register_taxonomy('community-city', ['communities'], $args);
});
