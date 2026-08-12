<?php

function codelibry_acf_fields_content_doc(): array
{
    return [
        [
            'label'        => 'Sections',
            'name'         => 'content-doc-sections',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Add Section',
            'sub_fields'   => [
                [
                    'label'    => 'Title',
                    'name'     => 'section-title',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => ['width' => '80'],
                ],
                [
                    'label'         => 'Title Tag',
                    'name'          => 'section-title-tag',
                    'type'          => 'select',
                    'choices'       => [
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                    ],
                    'default_value' => 'h2',
                    'allow_null'    => 0,
                    'ui'            => 0,
                    'wrapper'       => ['width' => '20'],
                ],
                [
                    'label'        => 'Content',
                    'name'         => 'section-content',
                    'type'         => 'wysiwyg',
                    'toolbar'      => 'full',
                    'media_upload' => 0,
                ],
                [
                    'label'        => 'Section Label',
                    'name'         => 'section-label',
                    'type'         => 'text',
                    'instructions' => 'Optional. Shown in the sidebar under "Section" while the visitor is reading this part of the document (e.g. "Warranty", "Legal"). Leave blank to hide the Section label for this part.',
                    'required'     => 0,
                ],
            ],
        ],
        [
            'label'          => 'Updated Date',
            'name'           => 'content-doc-updated',
            'type'           => 'date_picker',
            'display_format' => 'd/m/Y',
            'return_format'  => 'Y-m-d',
            'instructions'   => 'The date this content was last reviewed or updated. Shown in the sidebar as "Updated Month Year" (e.g. "Updated Jan 2026"). Please update this field every time you revise the content.',
            'wrapper'        => ['width' => '50'],
        ],
        [
            'label'        => 'Show "Last Reviewed" footer',
            'name'         => 'content-doc-show-reviewed',
            'type'         => 'true_false',
            'ui'           => 1,
            'instructions' => 'Check to display a "Last reviewed: Month Year" line below the content. The date is taken automatically from the Updated Date field on the left — no need to enter it separately.',
            'wrapper'      => ['width' => '50'],
        ],
        [
            'label'         => 'Download PDF',
            'name'          => 'content-doc-pdf',
            'type'          => 'link',
            'return_format' => 'array',
        ],
    ];
}
