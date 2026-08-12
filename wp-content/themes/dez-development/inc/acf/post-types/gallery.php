<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    ACFComposer::registerFieldGroup([
        'name'   => 'galleryItem',
        'title'  => 'Gallery Item',
        'fields' => [
            [
                'label'         => 'Image',
                'name'          => 'gallery-image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'required'      => 1,
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'gallery'],
            ],
        ],
        'menu_order' => 0,
    ]);
});
