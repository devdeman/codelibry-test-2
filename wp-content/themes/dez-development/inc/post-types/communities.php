<?php

add_action('init', function (): void {
    $labels = [
        'name'                  => _x('Communities', 'Post Type General Name', 'codelibry'),
        'singular_name'         => _x('Community', 'Post Type Singular Name', 'codelibry'),
        'menu_name'             => __('Communities', 'codelibry'),
        'name_admin_bar'        => __('Community', 'codelibry'),
        'archives'              => __('Community Archives', 'codelibry'),
        'attributes'            => __('Community Attributes', 'codelibry'),
        'parent_item_colon'     => __('Parent Community:', 'codelibry'),
        'all_items'             => __('All Communities', 'codelibry'),
        'add_new_item'          => __('Add New Community', 'codelibry'),
        'add_new'               => __('Add New', 'codelibry'),
        'new_item'              => __('New Community', 'codelibry'),
        'edit_item'             => __('Edit Community', 'codelibry'),
        'update_item'           => __('Update Community', 'codelibry'),
        'view_item'             => __('View Community', 'codelibry'),
        'view_items'            => __('View Communities', 'codelibry'),
        'search_items'          => __('Search Community', 'codelibry'),
        'not_found'             => __('Not found', 'codelibry'),
        'not_found_in_trash'    => __('Not found in Trash', 'codelibry'),
        'featured_image'        => __('Community Thumbnail', 'codelibry'),
        'set_featured_image'    => __('Set community thumbnail', 'codelibry'),
        'remove_featured_image' => __('Remove community thumbnail', 'codelibry'),
        'use_featured_image'    => __('Use as community thumbnail', 'codelibry'),
        'insert_into_item'      => __('Insert into Community', 'codelibry'),
        'uploaded_to_this_item' => __('Uploaded to this Community', 'codelibry'),
        'items_list'            => __('Communities list', 'codelibry'),
        'items_list_navigation' => __('Communities list navigation', 'codelibry'),
        'filter_items_list'     => __('Filter Communities list', 'codelibry'),
    ];

    $args = [
        'label'               => __('Communities', 'codelibry'),
        'description'         => __('Community post type', 'codelibry'),
        'labels'              => $labels,
        'supports'            => ['title', 'thumbnail'],
        'taxonomies'          => ['community-area', 'community-city', 'community-schools', 'community-status'],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-location',
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'rewrite'             => ['slug' => 'communities'],
    ];

    register_post_type('communities', $args);
});
