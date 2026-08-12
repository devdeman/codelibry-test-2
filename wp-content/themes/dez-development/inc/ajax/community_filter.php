<?php

function community_filter_callback()
{
    check_ajax_referer('community_filter_nonce', 'nonce');

    $tax_query = [];

    $taxonomy_map = [
        'state'   => 'community-state',
        'area'    => 'community-area',
        'city'    => 'community-city',
        'schools' => 'community-schools',
    ];

    foreach ($taxonomy_map as $param => $taxonomy) {
        $value = sanitize_text_field($_POST[$param] ?? '');
        if ($value) {
            $tax_query[] = [
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $value,
            ];
        }
    }

    $orderby       = sanitize_text_field($_POST['orderby'] ?? 'title_asc');
    $homes_orderby = sanitize_text_field($_POST['homes_orderby'] ?? '');

    $args = [
        'post_type'      => 'communities',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    if ($homes_orderby) {
        $args['meta_key'] = '_community_homes_count';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = $homes_orderby === 'desc' ? 'DESC' : 'ASC';
    } else {
        $order = $orderby === 'title_desc' ? 'DESC' : 'ASC';
        $args['orderby'] = 'title';
        $args['order']   = $order;
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);
    $total = $query->found_posts;

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part(
                'template-parts/parts/community-card',
                null,
                [
                    'show_location_btn' => true,
                    'post_id' => get_the_ID()
                ]
            );
        }
        wp_reset_postdata();
    }
    $html = ob_get_clean();
    $markers = extract_community_markers($query->posts);

    wp_send_json_success([
        'html'    => $html ?: '<p>' . esc_html__('No communities found.', 'codelibry') . '</p>',
        'total'   => $total,
        'markers' => $markers,
        'label'   => sprintf(
            _n('%d Community Found', '%d Communities Found', $total, 'codelibry'),
            $total
        ),
    ]);

    wp_die();
}

add_action('wp_ajax_community_filter', 'community_filter_callback');
add_action('wp_ajax_nopriv_community_filter', 'community_filter_callback');
