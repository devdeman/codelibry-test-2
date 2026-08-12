<?php

add_filter('allowed_block_types_all', 'restrict_block_types', 10, 2);

function restrict_block_types($allowed_blocks, $block_editor_context) {
    return [
        'core/heading',
        'core/paragraph',
        'core/list',
        'core/list-item',
        'core/quote',
        'core/pullquote',
        'core/details',
        'core/table',
        'core/verse',
        'core/image',
        'core/gallery',
        'core/media-text',
        'core/video',
        'core/separator',
        'core/spacer',
        'core/embed',
        'core/shortcode',
    ];
}
