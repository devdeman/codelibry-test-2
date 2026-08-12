<?php

/*
 * Limit post revisions to 3
 */
add_filter( 'wp_revisions_to_keep', function( $num, $post ) {
	return 3;
}, 10, 2 );
