<?php

add_action('init', function (): void {
    $labels = [
        'name'                       => _x('Gallery Categories', 'Taxonomy General Name', 'codelibry'),
        'singular_name'              => _x('Gallery Category', 'Taxonomy Singular Name', 'codelibry'),
        'menu_name'                  => __('Gallery Categories', 'codelibry'),
        'all_items'                  => __('All Gallery Categories', 'codelibry'),
        'parent_item'                => __('Parent Gallery Category', 'codelibry'),
        'parent_item_colon'          => __('Parent Gallery Category:', 'codelibry'),
        'new_item_name'              => __('New Gallery Category Name', 'codelibry'),
        'add_new_item'               => __('Add New Gallery Category', 'codelibry'),
        'edit_item'                  => __('Edit Gallery Category', 'codelibry'),
        'update_item'                => __('Update Gallery Category', 'codelibry'),
        'view_item'                  => __('View Gallery Category', 'codelibry'),
        'separate_items_with_commas' => __('Separate Gallery Categories with commas', 'codelibry'),
        'add_or_remove_items'        => __('Add or remove Gallery Categories', 'codelibry'),
        'choose_from_most_used'      => __('Choose from the most used', 'codelibry'),
        'popular_items'              => __('Popular Gallery Categories', 'codelibry'),
        'search_items'               => __('Search Gallery Categories', 'codelibry'),
        'not_found'                  => __('Not Found', 'codelibry'),
        'no_terms'                   => __('No Gallery Categories', 'codelibry'),
        'items_list'                 => __('Gallery Categories list', 'codelibry'),
        'items_list_navigation'      => __('Gallery Categories list navigation', 'codelibry'),
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => false,
        'rewrite'           => ['slug' => 'gallery-category'],
    ];

    register_taxonomy('gallery-category', ['gallery'], $args);
});
