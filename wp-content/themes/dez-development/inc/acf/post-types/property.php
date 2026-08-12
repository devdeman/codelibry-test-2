<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    ACFComposer::registerFieldGroup([
        'name'   => 'property',
        'title'  => 'Property',
        'fields' => [

            /* ===== TAB: DETAILS ===== */
            [
                'label'     => 'Details',
                'name'      => 'tab-details',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ],

            // Gallery
            [
                'label'         => 'Gallery',
                'name'          => 'property-gallery',
                'type'          => 'gallery',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'min'           => 1,
            ],

            // Info group
            [
                'label'      => 'Property Info',
                'name'       => 'property-info',
                'type'       => 'group',
                'layout'     => 'row',
                'sub_fields' => [
                    [
                        'label'   => 'Address',
                        'name'    => 'address',
                        'type'    => 'text',
                        'wrapper' => ['width' => '40'],
                    ],
                    [
                        'label'   => 'Price',
                        'name'    => 'price',
                        'type'    => 'text',
                        'wrapper' => ['width' => '20'],
                    ],
                    [
                        'label'   => 'Baths',
                        'name'    => 'baths',
                        'type'    => 'number',
                        'step'    => '0.5',
                        'min'     => 0,
                        'wrapper' => ['width' => '15'],
                    ],
                    [
                        'label'   => 'Sq Ft',
                        'name'    => 'sqft',
                        'type'    => 'number',
                        'min'     => 0,
                        'wrapper' => ['width' => '15'],
                    ],
                    [
                        'label'   => 'Floor Plan Name',
                        'name'    => 'floor-plan-name',
                        'type'    => 'text',
                        'wrapper' => ['width' => '10'],
                    ],
                ],
            ],

            // Map Location
            [
                'label'         => 'Map Location',
                'name'          => 'property-location',
                'type'          => 'google_map',
                'center_lat'    => '38.9072',
                'center_lng'    => '-77.0369',
                'zoom'          => 10,
                'height'        => 200,
            ],

            // Action Buttons repeater
            ...codelibry_acf_fields_shared_buttons('property'),

            // Description group
            [
                'label'      => 'Description',
                'name'       => 'property-description',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'label'         => 'Label',
                        'name'          => 'label',
                        'type'          => 'text',
                        'default_value' => 'About this home',
                        'wrapper'       => ['width' => '50'],
                    ],
                    [
                        'label'         => 'Title',
                        'name'          => 'title',
                        'type'          => 'text',
                        'default_value' => 'Property Description',
                        'wrapper'       => ['width' => '50'],
                    ],
                    [
                        'label'        => 'Text',
                        'name'         => 'text',
                        'type'         => 'wysiwyg',
                        'tabs'         => 'all',
                        'media_upload' => 0,
                    ],
                ],
            ],

            // Est. Monthly Payment group
            [
                'label'      => 'Est. Monthly Payment',
                'name'       => 'property-payment',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'label'         => 'Label',
                        'name'          => 'label',
                        'type'          => 'text',
                        'default_value' => 'Est. Monthly Payment',
                        'wrapper'       => ['width' => '50'],
                    ],
                    [
                        'label'   => 'Price ($/mo)',
                        'name'    => 'price',
                        'type'    => 'number',
                        'min'     => 0,
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'label'      => 'Details',
                        'name'       => 'details',
                        'type'       => 'repeater',
                        'layout'     => 'table',
                        'min'        => 0,
                        'max'        => 5,
                        'sub_fields' => [
                            [
                                'label'       => 'Amount',
                                'name'        => 'amount',
                                'type'        => 'text',
                                'placeholder' => '20%',
                                'wrapper'     => ['width' => '50'],
                            ],
                            [
                                'label'       => 'Description',
                                'name'        => 'description',
                                'type'        => 'text',
                                'placeholder' => 'down',
                                'wrapper'     => ['width' => '50'],
                            ],
                        ],
                    ],
                    [
                        'label'         => 'Calculator Link',
                        'name'          => 'calculator-link',
                        'type'          => 'link',
                        'return_format' => 'array',
                    ],
                ],
            ],

            // Floor Plan group
            [
                'label'      => 'Floor Plan',
                'name'       => 'property-floor-plan',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    [
                        'label'      => 'Floors',
                        'name'       => 'floors',
                        'type'       => 'repeater',
                        'layout'     => 'table',
                        'sub_fields' => [
                            [
                                'label'   => 'Tab Name',
                                'name'    => 'tab-name',
                                'type'    => 'text',
                                'wrapper' => ['width' => '33'],
                            ],
                            [
                                'label'         => 'Image',
                                'name'          => 'image',
                                'type'          => 'image',
                                'return_format' => 'id',
                                'preview_size'  => 'thumbnail',
                                'wrapper'       => ['width' => '33'],
                            ],
                            [
                                'label'   => 'Sq Ft',
                                'name'    => 'sqft',
                                'type'    => 'number',
                                'min'     => 0,
                                'wrapper' => ['width' => '34'],
                            ],
                        ],
                    ],
                    [
                        'label'         => 'Download PDF',
                        'name'          => 'pdf-link',
                        'type'          => 'link',
                        'return_format' => 'array',
                    ],
                ],
            ],

            // Reusable blocks
            [
                'label'         => 'Testimonials Block',
                'name'          => 'property-testimonials',
                'type'          => 'post_object',
                'post_type'     => ['reusable-blocks'],
                'return_format' => 'id',
                'ui'            => 1,
                'required'      => 0,
            ],
            [
                'label'         => 'CTA Block',
                'name'          => 'property-cta-single-property',
                'type'          => 'post_object',
                'post_type'     => ['reusable-blocks'],
                'return_format' => 'id',
                'ui'            => 1,
                'required'      => 0,
            ],

            // Cards Grid
            [
                'label'      => 'Cards Grid',
                'name'       => 'property-cards-grid',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => codelibry_acf_fields_cards_grid(),
            ],

            /* ===== TAB: SPECIFICATIONS ===== */
            [
                'label'     => 'Specifications',
                'name'      => 'tab-specifications',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ],

            // Property specs
            [
                'label'      => 'Property',
                'name'       => 'spec-property',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    ['label' => 'Address',    'name' => 'address',    'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Community',  'name' => 'community',  'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Status',     'name' => 'status',     'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Floor Plan', 'name' => 'floor-plan', 'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Year Built', 'name' => 'year-built', 'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Lot Size',   'name' => 'lot-size',   'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'MLS #',      'name' => 'mls',        'type' => 'text', 'wrapper' => ['width' => '50']],
                ],
            ],

            // Features specs
            [
                'label'      => 'Features',
                'name'       => 'spec-features',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    ['label' => 'Kitchen',  'name' => 'kitchen',  'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Flooring', 'name' => 'flooring', 'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Heating',  'name' => 'heating',  'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Cooling',  'name' => 'cooling',  'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Exterior', 'name' => 'exterior', 'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Outdoor',  'name' => 'outdoor',  'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Windows',  'name' => 'windows',  'type' => 'text', 'wrapper' => ['width' => '50']],
                ],
            ],

            // Home specs
            [
                'label'      => 'Home',
                'name'       => 'spec-home',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    ['label' => 'Total Sq Ft', 'name' => 'total-sqft', 'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Stories',     'name' => 'stories',    'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Bedrooms',    'name' => 'bedrooms',   'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Bathrooms',   'name' => 'bathrooms',  'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Garage',      'name' => 'garage',     'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Basement',    'name' => 'basement',   'type' => 'text', 'wrapper' => ['width' => '50']],
                ],
            ],

            // HOA & Financials specs
            [
                'label'      => 'HOA & Financials',
                'name'       => 'spec-hoa',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => [
                    ['label' => 'HOA',             'name' => 'hoa',             'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'HOA Includes',    'name' => 'hoa-includes',    'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'Property Tax',    'name' => 'property-tax',    'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['label' => 'School District', 'name' => 'school-district', 'type' => 'text', 'wrapper' => ['width' => '50']],
                ],
            ],

        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'property',
                ],
            ],
        ],
    ]);
});
