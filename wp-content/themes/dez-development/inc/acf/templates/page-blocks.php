<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
    ACFComposer::registerFieldGroup([
        'name'     => 'pageBlocks',
        'title'    => 'Page Blocks',
        'fields'   => [
            [
                'label'        => 'Blocks',
                'name'         => 'page-blocks',
                'type'         => 'flexible_content',
                'button_label' => 'Add Block',
                'layouts'      => [
                    [
                        'name'       => 'hero-home',
                        'label'      => 'Hero Home',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_hero_home(),
                    ],
                    [
                        'name'       => 'hero',
                        'label'      => 'Hero',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_hero(),
                    ],
                    [
                        'name'       => 'numbers',
                        'label'      => 'Numbers',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_numbers(),
                    ],
                    [
                        'name'       => 'image-text',
                        'label'      => 'Image & Text',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_image_text(),
                    ],
                    [
                        'name'       => 'testimonials',
                        'label'      => 'Testimonials',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_testimonials(),
                    ],
                    [
                        'name'       => 'cta',
                        'label'      => 'Call to Action',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_cta(),
                    ],
                    [
                        'name'       => 'process-cards',
                        'label'      => 'Process Cards',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_process_cards(),
                    ],
                    [
                        'name'       => 'managers',
                        'label'      => 'Managers',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_managers(),
                    ],
                    [
                        'name'       => 'cards-grid',
                        'label'      => 'Cards Grid',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_cards_grid(),
                    ],
                    [
                        'name'       => 'team',
                        'label'      => 'Team',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_team(),
                    ],
                    [
                        'name'       => 'awards',
                        'label'      => 'Awards',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_awards(),
                    ],
                    [
                        'name'       => 'form-section',
                        'label'      => 'Form Section',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_form_section(),
                    ],
                    [
                        'name'       => 'warranty-form',
                        'label'      => 'Warranty Form',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_warranty_form(),
                    ],
                    [
                        'name'       => 'gallery',
                        'label'      => 'Gallery',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_gallery(),
                    ],
                    [
                        'name'       => 'content-doc',
                        'label'      => 'Content Document',
                        'display'    => 'block',
                        'sub_fields' => codelibry_acf_fields_content_doc(),
                    ],
                    [
                        'name'       => 'reusable-block',
                        'label'      => 'Reusable Block',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'label'         => 'Reusable Block',
                                'name'          => 'reusable-block-post',
                                'type'          => 'post_object',
                                'post_type'     => ['reusable-blocks'],
                                'return_format' => 'id',
                                'multiple'      => 0,
                                'allow_null'    => 0,
                                'ui'            => 1,
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                ['param' => 'page_template', 'operator' => '==', 'value' => 'default'],
            ],
        ],
        'menu_order' => 0,
    ]);
});
