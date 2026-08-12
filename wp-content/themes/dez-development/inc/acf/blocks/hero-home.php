<?php

function codelibry_acf_fields_shared_title(string $prefix): array
{
  return [
    [
      'label'        => 'Title',
      'name'         => "{$prefix}-title",
      'type'     => 'text',
      'required' => 0,
    ],
  ];
}

function codelibry_acf_fields_shared_label(string $prefix): array
{
  return [
    [
      'label'        => 'Label',
      'name'         => "{$prefix}-label",
      'type'     => 'text',
      'required' => 0,
    ],
  ];
}

function codelibry_acf_fields_shared_text(string $prefix): array
{
  return [
    [
      'label'        => 'Text',
      'name'         => "{$prefix}-text",
      'type'         => 'wysiwyg',
      'tabs'         => 'all',
      'toolbar'      => 'full',
      'media_upload' => 1,
      'required'     => 0,
    ],
  ];
}

function codelibry_acf_fields_shared_image(string $prefix): array
{
  return [
    [
      'label'         => 'Image',
      'name'          => "{$prefix}-image",
      'type'          => 'image',
      'return_format' => 'id',
      'preview_size'  => 'medium',
      'required'      => 0,
    ],
  ];
}

function codelibry_acf_fields_shared_numbers(string $prefix): array
{
  return [
    [
      'label'        => 'Stats',
      'name'         => "{$prefix}-stats",
      'type'         => 'repeater',
      'layout'       => 'table',
      'button_label' => 'Add Stat',
      'min'          => 3,
      'max'          => 3,
      'sub_fields'   => [
        [
          'label'        => 'Title',
          'name'         => "title",
          'type'         => 'wysiwyg',
          'tabs'         => 'all',
          'toolbar'      => 'full',
          'media_upload' => 1,
          'required'     => 0,
        ],
        [
          'label'    => 'Text',
          'name'     => 'text',
          'type'     => 'text',
          'required' => 0,
        ],
      ],
    ],
  ];
}

function codelibry_acf_fields_shared_buttons(string $prefix): array
{
  return [
    [
      'label'        => 'Buttons',
      'name'         => "{$prefix}-buttons",
      'type'         => 'repeater',
      'layout'       => 'table',
      'button_label' => 'Add Button',
      'sub_fields'   => [
        [
          'label'         => 'Link',
          'name'          => 'link',
          'type'          => 'link',
          'return_format' => 'array',
          'required'      => 0,
          'wrapper'       => ['width' => '50'],
        ],
        [
          'label'         => 'Style',
          'name'          => 'style',
          'type'          => 'select',
          'choices'       => [
            'orange' => 'Orange',
            'black'   => 'Black',
            'white-outline' => 'White outline',
            'orange-outline' => 'Orange outline',
            'white' => 'White',
            'text-arrow' => 'Text Arrow',
          ],
          'default_value' => 'orange',
          'return_format' => 'value',
          'ui'            => 1,
          'required'      => 0,
          'wrapper'       => ['width' => '50'],
        ],
      ],
    ],
  ];
}

function codelibry_acf_fields_shared_post_object(string $prefix): array
{
  // Extract CPT from the prefix (for example, 'testimonials-slider' -> 'testimonials')
  $cpt = explode('-', $prefix)[0];
  return [
    [
      'label'         => 'Post Object',
      'name'          => "{$prefix}-post-object",
      'type'          => 'post_object',
      'required'      => 0,
      'multiple'      => 1,
      'post_type'     => [$cpt],
      'return_format' => 'id',
      'ui'            => 1,
    ],
  ];
}

function codelibry_acf_fields_hero_home(): array
{
  return array_merge(
    codelibry_acf_fields_shared_text('hero-home'),
    codelibry_acf_fields_shared_image('hero-home'),
    [
      [
        'label'         => 'Mobile image',
        'name'          => 'hero-home-image-mobile',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium',
        'required'      => 0,
        'instructions'  => 'Use this mobile-only image for screens narrower than 560px. If empty, the default hero image will be used instead.',
      ],
    ]
  );
}

function codelibry_acf_fields_hero(): array
{
  return array_merge(
    codelibry_acf_fields_shared_text('hero'),
    codelibry_acf_fields_shared_image('hero'),
  );
}
