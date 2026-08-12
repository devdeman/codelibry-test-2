<?php

function gallery_filter_callback() {
    check_ajax_referer('gallery_filter_nonce', 'nonce');

    $per_page = max(1, min(48, (int) sanitize_text_field($_POST['per_page'] ?? 7)));
    $offset   = max(0, (int) sanitize_text_field($_POST['offset'] ?? 0));
    $category = sanitize_text_field($_POST['category'] ?? '');

    $tax_query = [];
    if ($category) {
        $tax_query = [[
            'taxonomy' => 'gallery-category',
            'field'    => 'slug',
            'terms'    => $category,
        ]];
    }

    $count_args = [
        'post_type'      => 'gallery',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ];
    if ($tax_query) {
        $count_args['tax_query'] = $tax_query;
    }
    $total_query = new WP_Query($count_args);
    $total       = $total_query->found_posts;
    wp_reset_postdata();

    $query_args = [
        'post_type'      => 'gallery',
        'posts_per_page' => $per_page,
        'offset'         => $offset,
        'post_status'    => 'publish',
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
    ];
    if ($tax_query) {
        $query_args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($query_args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image_id = get_field('gallery-image', get_the_ID()) ?: get_post_thumbnail_id(get_the_ID());
            if (!$image_id) continue;
            get_template_part('template-parts/parts/gallery-item', null, ['image_id' => (int) $image_id]);
        }
        wp_reset_postdata();
    }
    $html = ob_get_clean();

    $shown = $offset + $query->post_count;

    wp_send_json_success([
        'html'     => $html,
        'has_more' => $shown < $total,
        'shown'    => $shown,
        'total'    => $total,
    ]);

    wp_die();
}

add_action('wp_ajax_gallery_filter', 'gallery_filter_callback');
add_action('wp_ajax_nopriv_gallery_filter', 'gallery_filter_callback');
