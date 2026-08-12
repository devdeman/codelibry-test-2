<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    ACFComposer::registerFieldGroup([
        'name'   => 'award',
        'title'  => 'Award',
        'fields' => [
            [
                'label'    => 'Description',
                'name'     => 'description',
                'type'     => 'textarea',
                'rows'     => 3,
                'required' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'award',
                ],
            ],
        ],
    ]);
});
