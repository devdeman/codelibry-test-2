<?php

/*
 * Enqueue Styles
 */
function codelibry_enqueue_styles()
{
  $style_version = filemtime(CODELIBRY_THEME_PATH . "/dist/css/main.min.css");
  wp_enqueue_style('main-style', CODELIBRY_THEME_URI . "/dist/css/main.min.css", [], $style_version, 'all');
}
add_action('wp_enqueue_scripts', 'codelibry_enqueue_styles', 999999);


/*
 * Enqueue Scripts
 */
function codelibry_enqueue_js()
{
  $script_version = filemtime(CODELIBRY_THEME_PATH . "/dist/main.min.js");
  wp_enqueue_script('main-script', CODELIBRY_THEME_URI . "/dist/main.min.js", [], $script_version, true);

  // Passing PHP variables to JavaScript
  wp_localize_script('main-script', 'site', [
    'ajax_url'               => admin_url('admin-ajax.php'),
    'ajax_nonce'             => wp_create_nonce('secure_nonce_name'),
    'community_filter_nonce' => wp_create_nonce('community_filter_nonce'),
    'property_filter_nonce'  => wp_create_nonce('property_filter_nonce'),
    'site_url'               => get_site_url(),
    'theme_url'              => get_template_directory_uri(),
     // 'themeUrl' => get_template_directory_uri(),
  ]);

  if (is_post_type_archive('communities')) {
    $gmaps_key = get_field('google_maps_api_key', 'option') ?: 'AIzaSyBwn3PwSZBITWbqHJd998SOAeAQpNo6QSA';
    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . urlencode($gmaps_key), [], null, true);
    wp_localize_script('main-script', 'communityMapMarkers', [
      'markers' => get_community_map_markers(),
    ]);
  }

  if (is_post_type_archive('property')) {
    $gmaps_key = get_field('google_maps_api_key', 'option') ?: 'AIzaSyBwn3PwSZBITWbqHJd998SOAeAQpNo6QSA';
    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . urlencode($gmaps_key), [], null, true);
    wp_localize_script('main-script', 'propertyMapMarkers', [
      'markers' => get_property_map_markers(),
    ]);
  }


}
add_action('wp_enqueue_scripts', 'codelibry_enqueue_js');

function get_community_map_markers() {
  global $wp_query;
  return extract_community_markers($wp_query->posts);
}

function get_property_map_markers() {
  global $wp_query;
  return extract_property_markers($wp_query->posts);
}
