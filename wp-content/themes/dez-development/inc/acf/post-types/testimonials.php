<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    ACFComposer::registerFieldGroup([
        'name'     => 'testimonial',
        'title'    => 'Testimonial',
        'fields'   => [
            [
                'label' => 'Author Name',
                'name'  => 'author-name',
                'type'  => 'text',
                'wrapper'       => ['width' => '50'],
            ],
            [
                'label'         => 'Image',
                'name'          => "image",
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'required'      => 0,
                'wrapper'       => ['width' => '50'],
            ],
            [
                'label'        => 'Content',
                'name'         => 'content',
                'type'         => 'wysiwyg',
                'media_upload' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'testimonials',
                ],
            ],
        ],
    ]);
});
