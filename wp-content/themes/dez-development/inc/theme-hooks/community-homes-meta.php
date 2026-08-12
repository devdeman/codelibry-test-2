<?php

function recalc_community_homes_count($post_id) {
    $status_terms = get_the_terms($post_id, 'community-status');
    $area_terms   = get_the_terms($post_id, 'community-area');

    if (!$status_terms || is_wp_error($status_terms)) {
        update_post_meta($post_id, '_community_homes_count', 0);
        return;
    }

    $property_status_map = [
        'models-now-open' => 'active',
        'coming-soon'     => 'under-construction',
    ];
    $property_status_slug = $property_status_map[$status_terms[0]->slug] ?? null;

    if (!$property_status_slug) {
        update_post_meta($post_id, '_community_homes_count', 0);
        return;
    }

    $tax_query = [
        [
            'taxonomy' => 'property-status',
            'field'    => 'slug',
            'terms'    => $property_status_slug,
        ],
    ];

    if ($area_terms && !is_wp_error($area_terms)) {
        $tax_query[] = [
            'taxonomy' => 'property-area',
            'field'    => 'slug',
            'terms'    => $area_terms[0]->slug,
        ];
    }

    $property_ids = get_posts([
        'post_type'      => 'property',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => $tax_query,
    ]);

    $homes_count = count($property_ids);

    $price_query_args = [
        'post_type'      => 'property',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ];
    if ($area_terms && !is_wp_error($area_terms)) {
        $price_query_args['tax_query'] = [[
            'taxonomy' => 'property-area',
            'field'    => 'slug',
            'terms'    => $area_terms[0]->slug,
        ]];
    }
    $price_ids = get_posts($price_query_args);

    $min_price = null;
    foreach ($price_ids as $pid) {
        $info      = get_field('property-info', $pid) ?: [];
        $raw_price = $info['price'] ?? '';
        $price_num = (int) preg_replace('/[^0-9]/', '', $raw_price);
        if ($price_num > 0 && ($min_price === null || $price_num < $min_price)) {
            $min_price = $price_num;
        }
    }

    update_post_meta($post_id, '_community_homes_count', $homes_count);
    update_post_meta($post_id, '_community_min_price', $min_price);
}

add_action('save_post_communities', 'recalc_community_homes_count');

add_action('pre_post_update', function ($post_id) {
    if (get_post_type($post_id) !== 'property') return;
    $terms = get_the_terms($post_id, 'property-area');
    if ($terms && !is_wp_error($terms)) {
        $GLOBALS['_old_property_area'][$post_id] = $terms[0]->slug;
    }
});

add_action('save_post_property', function ($post_id) {
    $area_terms = get_the_terms($post_id, 'property-area');
    if (!$area_terms || is_wp_error($area_terms)) return;

    $new_slug = $area_terms[0]->slug;
    $old_slug = $GLOBALS['_old_property_area'][$post_id] ?? null;

    $slugs_to_recalc = $old_slug && $old_slug !== $new_slug
        ? [$new_slug, $old_slug]
        : [$new_slug];

    foreach ($slugs_to_recalc as $slug) {
        $communities = get_posts([
            'post_type'      => 'communities',
            'fields'         => 'ids',
            'posts_per_page' => -1,
            'tax_query'      => [[
                'taxonomy' => 'community-area',
                'field'    => 'slug',
                'terms'    => $slug,
            ]],
        ]);

        foreach ($communities as $cid) {
            recalc_community_homes_count($cid);
        }
    }

    unset($GLOBALS['_old_property_area'][$post_id]);
});

function backfill_community_homes_count() {
    if (empty($_GET['recalc_homes'])) return;

    $communities = get_posts([
        'post_type'      => 'communities',
        'fields'         => 'ids',
        'posts_per_page' => -1,
    ]);

    foreach ($communities as $cid) {
        recalc_community_homes_count($cid);
    }

    wp_die('Recalculated homes count for ' . count($communities) . ' communities.');
}

add_action('wp_loaded', 'backfill_community_homes_count');
