<?php

add_action('init', function (): void {
    $labels = [
        'name'                  => _x('Properties', 'Post Type General Name', 'codelibry'),
        'singular_name'         => _x('Property', 'Post Type Singular Name', 'codelibry'),
        'menu_name'             => __('Properties', 'codelibry'),
        'name_admin_bar'        => __('Property', 'codelibry'),
        'all_items'             => __('All Properties', 'codelibry'),
        'add_new_item'          => __('Add New Property', 'codelibry'),
        'add_new'               => __('Add New', 'codelibry'),
        'new_item'              => __('New Property', 'codelibry'),
        'edit_item'             => __('Edit Property', 'codelibry'),
        'update_item'           => __('Update Property', 'codelibry'),
        'view_item'             => __('View Property', 'codelibry'),
        'view_items'            => __('View Properties', 'codelibry'),
        'search_items'          => __('Search Property', 'codelibry'),
        'not_found'             => __('Not found', 'codelibry'),
        'not_found_in_trash'    => __('Not found in Trash', 'codelibry'),
        'featured_image'        => __('Property Thumbnail', 'codelibry'),
        'set_featured_image'    => __('Set property thumbnail', 'codelibry'),
        'remove_featured_image' => __('Remove property thumbnail', 'codelibry'),
        'use_featured_image'    => __('Use as property thumbnail', 'codelibry'),
        'items_list'            => __('Properties list', 'codelibry'),
        'items_list_navigation' => __('Properties list navigation', 'codelibry'),
    ];

    $args = [
        'label'               => __('Properties', 'codelibry'),
        'description'         => __('Property post type', 'codelibry'),
        'labels'              => $labels,
        'supports'            => ['title', 'thumbnail'],
        'taxonomies'          => [
            'property-area',
            'property-city',
            'property-beds',
            'property-garage',
            'property-price-range',
            'property-sqft',
            'property-status',
            'property-schools',
        ],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-admin-home',
        'menu_position'       => 6,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'can_export'          => true,
        'has_archive'         => 'homes',
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'rewrite'             => ['slug' => 'properties'],
    ];

    register_post_type('property', $args);
});
