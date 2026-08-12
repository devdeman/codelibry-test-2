<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    ACFComposer::registerFieldGroup([
        'name'   => 'community',
        'title'  => 'Community',
        'fields' => [
            [
                'label'      => 'Hero',
                'name'       => 'community-hero',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'label'         => 'Image',
                        'name'          => 'image',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size'  => 'medium',
                        'instructions'  => 'Optional. If empty, the post thumbnail will be used. If no thumbnail is set, the placeholder from Theme Options → Placeholders will be used.',
                    ],
                    [
                        'label'   => 'Label',
                        'name'    => 'label',
                        'type'    => 'text',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'label'        => 'Text',
                        'name'         => 'text',
                        'type'         => 'wysiwyg',
                        'media_upload' => 0,
                    ],
                ],
            ],
            [
                'label'      => 'Description',
                'name'       => 'community-description',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'label'         => 'Label',
                        'name'          => 'label',
                        'type'          => 'text',
                        'wrapper'       => ['width' => '50'],
                        'default_value' => 'About the area',
                    ],
                    [
                        'label'   => 'Title',
                        'name'    => 'title',
                        'type'    => 'text',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'label'        => 'Text',
                        'name'         => 'text',
                        'type'         => 'wysiwyg',
                        'media_upload' => 0,
                    ],
                    [
                        'label'      => 'Lifestyle Tags',
                        'name'       => 'tags',
                        'type'       => 'repeater',
                        'layout'     => 'table',
                        'min'        => 0,
                        'sub_fields' => [
                            [
                                'label' => 'Tag',
                                'name'  => 'tag',
                                'type'  => 'text',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label'      => 'Location Highlights',
                'name'       => 'community-highlights',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'label'         => 'Label',
                        'name'          => 'label',
                        'type'          => 'text',
                        'wrapper'       => ['width' => '50'],
                        'default_value' => 'Highlights',
                    ],
                    [
                        'label'         => 'Title',
                        'name'          => 'title',
                        'type'          => 'text',
                        'wrapper'       => ['width' => '50'],
                        'default_value' => 'Location Highlights',
                    ],
                    [
                        'label'      => 'Items',
                        'name'       => 'items',
                        'type'       => 'repeater',
                        'layout'     => 'table',
                        'sub_fields' => [
                            [
                                'label' => 'Item',
                                'name'  => 'text',
                                'type'  => 'text',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label'      => 'School Districts',
                'name'       => 'community-schools',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'label'         => 'Label',
                        'name'          => 'label',
                        'type'          => 'text',
                        'wrapper'       => ['width' => '50'],
                        'default_value' => 'Schools',
                    ],
                    [
                        'label'         => 'Title',
                        'name'          => 'title',
                        'type'          => 'text',
                        'wrapper'       => ['width' => '50'],
                        'default_value' => 'School Districts',
                    ],
                    [
                        'label'      => 'Items',
                        'name'       => 'items',
                        'type'       => 'repeater',
                        'layout'     => 'table',
                        'sub_fields' => [
                            [
                                'label' => 'Item',
                                'name'  => 'text',
                                'type'  => 'text',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label'         => 'Map Location',
                'name'          => 'community-location',
                'type'          => 'google_map',
                'center_lat'    => '38.9072',
                'center_lng'    => '-77.0369',
                'zoom'          => 10,
                'height'        => 200,
            ],

            // Cards Grid
            [
                'label'      => 'Cards Grid',
                'name'       => 'community-cards-grid',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => codelibry_acf_fields_cards_grid(),
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'communities',
                ],
            ],
        ],
    ]);
});
