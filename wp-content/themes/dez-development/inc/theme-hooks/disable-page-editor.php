<?php

add_action( 'admin_init', function () {
  $post_id = $_GET['post'] ?? $_POST['post_ID'] ?? null;

  if ( ! $post_id ) {
    remove_post_type_support( 'page', 'editor' );
    return;
  }

  $template = get_post_meta( $post_id, '_wp_page_template', true );

  if ( $template !== 'page-templates/content-page.php' ) {
    remove_post_type_support( 'page', 'editor' );
  }
} );
