<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    ACFComposer::registerFieldGroup([
        'name'   => 'teamMember',
        'title'  => 'Team Member',
        'fields' => [
            [
                'label'    => 'Position',
                'name'     => 'position',
                'type'     => 'text',
                'required' => 0,
            ],
            [
                'label'         => 'Contact Link',
                'name'          => 'contact-link',
                'type'          => 'link',
                'return_format' => 'array',
                'required'      => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'team-member',
                ],
            ],
        ],
    ]);
});
