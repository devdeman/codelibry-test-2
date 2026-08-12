<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    ACFComposer::registerFieldGroup([
        'name'   => 'reusableBlocks',
        'title'  => 'Reusable Block',
        'fields' => [
            [
                'label'        => 'Blocks',
                'name'         => 'reusable-blocks',
                'type'         => 'flexible_content',
                'button_label' => 'Add Block',
                'layouts'      => [
                    [
                        'name'       => 'cta',
                        'label'      => 'Call to Action',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_cta(),
                    ],
                    [
                        'name'       => 'cta-single-property',
                        'label'      => 'Call to Action for single Property',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_cta_single_property(),
                    ],
                    [
                        'name'       => 'testimonials-slider',
                        'label'      => 'Testimonials Slider',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_testimonials_slider(),
                    ],
                ],
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'reusable-blocks'],
            ],
        ],
    ]);
});
