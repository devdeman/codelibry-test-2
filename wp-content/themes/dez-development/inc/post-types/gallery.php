<?php

add_action('init', function (): void {
    $labels = [
        'name'                  => _x('Gallery', 'Post Type General Name', 'codelibry'),
        'singular_name'         => _x('Gallery Item', 'Post Type Singular Name', 'codelibry'),
        'menu_name'             => __('Gallery', 'codelibry'),
        'name_admin_bar'        => __('Gallery Item', 'codelibry'),
        'archives'              => __('Gallery Archives', 'codelibry'),
        'attributes'            => __('Gallery Item Attributes', 'codelibry'),
        'parent_item_colon'     => __('Parent Gallery Item:', 'codelibry'),
        'all_items'             => __('All Gallery Items', 'codelibry'),
        'add_new_item'          => __('Add New Gallery Item', 'codelibry'),
        'add_new'               => __('Add New', 'codelibry'),
        'new_item'              => __('New Gallery Item', 'codelibry'),
        'edit_item'             => __('Edit Gallery Item', 'codelibry'),
        'update_item'           => __('Update Gallery Item', 'codelibry'),
        'view_item'             => __('View Gallery Item', 'codelibry'),
        'view_items'            => __('View Gallery Items', 'codelibry'),
        'search_items'          => __('Search Gallery Item', 'codelibry'),
        'not_found'             => __('Not found', 'codelibry'),
        'not_found_in_trash'    => __('Not found in Trash', 'codelibry'),
        'featured_image'        => __('Gallery Item Image', 'codelibry'),
        'set_featured_image'    => __('Set gallery item image', 'codelibry'),
        'remove_featured_image' => __('Remove gallery item image', 'codelibry'),
        'use_featured_image'    => __('Use as gallery item image', 'codelibry'),
        'insert_into_item'      => __('Insert into Gallery Item', 'codelibry'),
        'uploaded_to_this_item' => __('Uploaded to this Gallery Item', 'codelibry'),
        'items_list'            => __('Gallery list', 'codelibry'),
        'items_list_navigation' => __('Gallery list navigation', 'codelibry'),
        'filter_items_list'     => __('Filter Gallery list', 'codelibry'),
    ];

    $args = [
        'label'               => __('Gallery', 'codelibry'),
        'description'         => __('Gallery post type', 'codelibry'),
        'labels'              => $labels,
        'supports'            => ['title'],
        'taxonomies'          => [],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-format-gallery',
        'menu_position'       => 6,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => false,
        'show_in_rest'        => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
    ];

    register_post_type('gallery', $args);
});
