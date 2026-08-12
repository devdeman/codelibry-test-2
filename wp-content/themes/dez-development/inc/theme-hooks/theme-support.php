<?php 

/*
 * Add Theme Support
 */
function codelibry_supports(){

  // WordPress Support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
}

add_action( 'after_setup_theme', 'codelibry_supports' );
