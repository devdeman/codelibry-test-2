<?php

// Show correct row count in admin before first save (UX only — no text values yet).
add_filter('acf/load_value/name=items', function ($value, $post_id, $field) {
    if (get_post_type($post_id) !== 'communities') return $value;
    if (!empty($value)) return $value;

    $parent = acf_get_field($field['parent']);
    if (!$parent || $parent['name'] !== 'community-schools') return $value;

    $terms = wp_get_post_terms($post_id, 'community-schools', ['orderby' => 'name', 'order' => 'ASC']);
    if (empty($terms) || is_wp_error($terms)) return $value;

    return array_fill(0, count($terms), []);
}, 10, 3);

// After saving, write taxonomy term names into meta so they appear on the next load.
// Skips if any item already has non-empty text (i.e. user has edited the field).
add_action('acf/save_post', function ($post_id) {
    if (get_post_type($post_id) !== 'communities') return;

    $terms = wp_get_post_terms($post_id, 'community-schools', ['orderby' => 'name', 'order' => 'ASC']);
    if (empty($terms) || is_wp_error($terms)) return;

    // If any row already has a non-empty text value, the user has edited — bail out.
    $saved_count = (int) get_post_meta($post_id, 'community-schools_items', true);
    for ($i = 0; $i < $saved_count; $i++) {
        if ('' !== get_post_meta($post_id, "community-schools_items_{$i}_text", true)) return;
    }

    // Resolve ACF field keys so get_field() works correctly on the frontend.
    $items_key = null;
    $text_key  = null;
    foreach (acf_get_field_groups(['post_type' => 'communities']) as $group) {
        foreach ((acf_get_fields($group['key']) ?: []) as $f) {
            if ($f['name'] !== 'community-schools') continue;
            foreach ($f['sub_fields'] as $sf) {
                if ($sf['name'] !== 'items') continue;
                $items_key = $sf['key'];
                foreach ($sf['sub_fields'] as $ssf) {
                    if ($ssf['name'] === 'text') {
                        $text_key = $ssf['key'];
                        break 3;
                    }
                }
            }
        }
    }
    if (!$items_key || !$text_key) return;

    update_post_meta($post_id, 'community-schools_items', count($terms));
    update_post_meta($post_id, '_community-schools_items', $items_key);

    foreach ($terms as $i => $term) {
        update_post_meta($post_id, "community-schools_items_{$i}_text", $term->name);
        update_post_meta($post_id, "_community-schools_items_{$i}_text", $text_key);
    }
}, 20);
