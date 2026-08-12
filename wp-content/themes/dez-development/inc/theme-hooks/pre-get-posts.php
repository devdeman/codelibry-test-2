<?php

function codelibry_property_archive_query($query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_post_type_archive('property')) {
        return;
    }

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
        $value = isset($_GET[$param]) ? sanitize_text_field($_GET[$param]) : '';
        if ($value) {
            $tax_query[] = [
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $value,
            ];
        }
    }

    if (!empty($tax_query)) {
        $query->set('tax_query', $tax_query);
    }

    $query->set('posts_per_page', -1);

    $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : '';
    $query->set('orderby', 'title');
    $query->set('order', $orderby === 'title_desc' ? 'DESC' : 'ASC');
}
add_action('pre_get_posts', 'codelibry_property_archive_query');
