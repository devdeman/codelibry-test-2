<?php

function property_filter_callback() {
    check_ajax_referer('property_filter_nonce', 'nonce');

    $taxonomy_map = [
        'state'       => 'property-state',
        'area'        => 'property-area',
        'city'        => 'property-city',
        'beds'        => 'property-beds',
        'garage'      => 'property-garage',
        'price_range' => 'property-price-range',
        'sqft'        => 'property-sqft',
        'status'      => 'property-status',
        'schools'     => 'property-schools',
    ];

    $tax_query = [];
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

    $orderby = sanitize_text_field($_POST['orderby'] ?? 'title_asc');
    $order   = $orderby === 'title_desc' ? 'DESC' : 'ASC';

    $args = [
        'post_type'      => 'property',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => $order,
    ];

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);
    $total = $query->found_posts;

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/parts/property-card', null, ['post_id' => get_the_ID(), 'show_location_btn' => true]);
        }
        wp_reset_postdata();
    }
    $html = ob_get_clean();

    $markers = extract_property_markers($query->posts);

    wp_send_json_success([
        'html'  => $html ?: '<p>' . esc_html__('No homes found.', 'codelibry') . '</p>',
        'total' => $total,
        'label' => sprintf(
            _n('%d Home Found', '%d Homes Found', $total, 'codelibry'),
            $total
        ),
        'markers' => $markers,
    ]);

    wp_die();
}

add_action('wp_ajax_property_filter', 'property_filter_callback');
add_action('wp_ajax_nopriv_property_filter', 'property_filter_callback');
