<?php

add_action( 'admin_menu', function () {
    global $submenu;

    $parent = 'edit.php?post_type=acf-field-group';

    if ( ! isset( $submenu[ $parent ] ) ) {
        return;
    }

    foreach ( $submenu[ $parent ] as $key => $item ) {
        if ( ( $item[2] ?? '' ) !== 'acf-settings-updates' ) {
            unset( $submenu[ $parent ][ $key ] );
        }
    }
}, 999 );
