<?php

/*
 * Allow JSON and SVG uploads in the media library
 */
add_filter( 'upload_mimes', function( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	$mimes['json'] = 'application/json';
	return $mimes;
} );

add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) {
	if ( ! empty( $data['ext'] ) && ! empty( $data['type'] ) ) {
		return $data;
	}

	$ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

	if ( 'svg' === $ext || 'svgz' === $ext ) {
		$data['ext']  = $ext;
		$data['type'] = 'image/svg+xml';
	} elseif ( 'json' === $ext ) {
		$data['ext']  = 'json';
		$data['type'] = 'application/json';
	}

	return $data;
}, 10, 4 );
