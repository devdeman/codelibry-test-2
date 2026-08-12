<?php

function extract_community_markers($posts) {
  $markers = [];
  foreach ($posts as $post) {
    $location = get_field('community-location', $post->ID);
    if ($location && !empty($location['lat']) && !empty($location['lng'])) {
      $city_terms = get_the_terms($post->ID, 'community-city');
      $city       = !empty($city_terms) && !is_wp_error($city_terms) ? $city_terms[0]->name : '';

      $min_price       = get_post_meta($post->ID, '_community_min_price', true);
      $formatted_price = $min_price ? 'Priced From $' . round((int) $min_price / 1000) . 'k' : '';

      $markers[] = [
        'id'    => $post->ID,
        'title' => get_the_title($post->ID),
        'lat'   => (float) $location['lat'],
        'lng'   => (float) $location['lng'],
        'city'  => $city,
        'price' => $formatted_price,
        'link'  => get_permalink($post->ID),
        'image' => get_the_post_thumbnail_url($post->ID, 'medium') ?: '',
      ];
    }
  }
  return $markers;
}

function extract_property_markers($posts) {
  $markers = [];
  foreach ($posts as $post) {
    $location = get_field('property-location', $post->ID);
    if ($location && !empty($location['lat']) && !empty($location['lng'])) {
      $info  = get_field('property-info', $post->ID) ?: [];
      $price = !empty($info['price']) ? '$' . esc_html($info['price']) : '';
      $address = $info['address'] ?? '';

      $city_terms = get_the_terms($post->ID, 'property-city');
      $city       = !empty($city_terms) && !is_wp_error($city_terms) ? $city_terms[0]->name : '';

      $markers[] = [
        'id'    => $post->ID,
        'title' => get_the_title($post->ID),
        'lat'   => (float) $location['lat'],
        'lng'   => (float) $location['lng'],
        'city'  => $city,
        'price' => $price,
        'link'  => get_permalink($post->ID),
        'image' => get_the_post_thumbnail_url($post->ID, 'medium') ?: '',
      ];
    }
  }
  return $markers;
}
