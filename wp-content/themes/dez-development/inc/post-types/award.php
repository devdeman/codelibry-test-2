<?php

add_action('init', function (): void {
    $labels = [
        'name'                  => _x('Awards', 'Post Type General Name', 'codelibry'),
        'singular_name'         => _x('Award', 'Post Type Singular Name', 'codelibry'),
        'menu_name'             => __('Awards', 'codelibry'),
        'name_admin_bar'        => __('Award', 'codelibry'),
        'archives'              => __('Award Archives', 'codelibry'),
        'attributes'            => __('Award Attributes', 'codelibry'),
        'parent_item_colon'     => __('Parent Award:', 'codelibry'),
        'all_items'             => __('All Awards', 'codelibry'),
        'add_new_item'          => __('Add New Award', 'codelibry'),
        'add_new'               => __('Add New', 'codelibry'),
        'new_item'              => __('New Award', 'codelibry'),
        'edit_item'             => __('Edit Award', 'codelibry'),
        'update_item'           => __('Update Award', 'codelibry'),
        'view_item'             => __('View Award', 'codelibry'),
        'view_items'            => __('View Awards', 'codelibry'),
        'search_items'          => __('Search Award', 'codelibry'),
        'not_found'             => __('Not found', 'codelibry'),
        'not_found_in_trash'    => __('Not found in Trash', 'codelibry'),
        'featured_image'        => __('Award Image', 'codelibry'),
        'set_featured_image'    => __('Set award image', 'codelibry'),
        'remove_featured_image' => __('Remove award image', 'codelibry'),
        'use_featured_image'    => __('Use as award image', 'codelibry'),
        'insert_into_item'      => __('Insert into Award', 'codelibry'),
        'uploaded_to_this_item' => __('Uploaded to this Award', 'codelibry'),
        'items_list'            => __('Awards list', 'codelibry'),
        'items_list_navigation' => __('Awards list navigation', 'codelibry'),
        'filter_items_list'     => __('Filter Awards list', 'codelibry'),
    ];

    $args = [
        'label'               => __('Awards', 'codelibry'),
        'description'         => __('Award post type', 'codelibry'),
        'labels'              => $labels,
        'supports'            => ['title', 'thumbnail'],
        'taxonomies'          => [],
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-star-filled',
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => false,
        'show_in_rest'        => true,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => 'post',
    ];

    register_post_type('award', $args);
});
