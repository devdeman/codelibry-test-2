<?php

add_action('init', function (): void {
    $labels = [
        'name'                  => _x('Team Members', 'Post Type General Name', 'codelibry'),
        'singular_name'         => _x('Team Member', 'Post Type Singular Name', 'codelibry'),
        'menu_name'             => __('Team Members', 'codelibry'),
        'name_admin_bar'        => __('Team Member', 'codelibry'),
        'archives'              => __('Team Member Archives', 'codelibry'),
        'attributes'            => __('Team Member Attributes', 'codelibry'),
        'parent_item_colon'     => __('Parent Team Member:', 'codelibry'),
        'all_items'             => __('All Team Members', 'codelibry'),
        'add_new_item'          => __('Add New Team Member', 'codelibry'),
        'add_new'               => __('Add New', 'codelibry'),
        'new_item'              => __('New Team Member', 'codelibry'),
        'edit_item'             => __('Edit Team Member', 'codelibry'),
        'update_item'           => __('Update Team Member', 'codelibry'),
        'view_item'             => __('View Team Member', 'codelibry'),
        'view_items'            => __('View Team Members', 'codelibry'),
        'search_items'          => __('Search Team Member', 'codelibry'),
        'not_found'             => __('Not found', 'codelibry'),
        'not_found_in_trash'    => __('Not found in Trash', 'codelibry'),
        'featured_image'        => __('Photo', 'codelibry'),
        'set_featured_image'    => __('Set photo', 'codelibry'),
        'remove_featured_image' => __('Remove photo', 'codelibry'),
        'use_featured_image'    => __('Use as photo', 'codelibry'),
        'insert_into_item'      => __('Insert into Team Member', 'codelibry'),
        'uploaded_to_this_item' => __('Uploaded to this Team Member', 'codelibry'),
        'items_list'            => __('Team Members list', 'codelibry'),
        'items_list_navigation' => __('Team Members list navigation', 'codelibry'),
        'filter_items_list'     => __('Filter Team Members list', 'codelibry'),
    ];

    $args = [
        'label'               => __('Team Members', 'codelibry'),
        'description'         => __('Team Member post type', 'codelibry'),
        'labels'              => $labels,
        'supports'            => ['title', 'thumbnail'],
        'taxonomies'          => [],
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-groups',
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

    register_post_type('team-member', $args);
});
