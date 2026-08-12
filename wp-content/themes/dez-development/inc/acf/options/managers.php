<?php

use ACFComposer\ACFComposer;

add_action('acf/init', function () {
  if (function_exists('acf_add_options_sub_page')) {
    acf_add_options_sub_page([
      'page_title'  => 'Managers',
      'menu_title'  => 'Managers',
      'menu_slug'   => 'theme-options-managers',
      'parent_slug' => 'theme-options',
      'capability'  => 'edit_theme_options',
    ]);
  }

  $manager_types = [
    ['slug' => 'sales-director',               'label' => 'Sales Director'],
    ['slug' => 'sales-agent',                  'label' => 'Sales Agent'],
    ['slug' => 'realtor-relations-manager',    'label' => 'Realtor Relations Manager'],
    ['slug' => 'warranty-after-sales-manager', 'label' => 'Warranty & After-Sales Manager'],
  ];

  $contact_group = fn(string $label, string $link_label, string $link_type = 'text') => [
    'label'      => $label,
    'name'       => strtolower($label),
    'type'       => 'group',
    'layout'     => 'row',
    'sub_fields' => [
      [
        'label'         => 'Icon',
        'name'          => 'icon',
        'type'          => 'image',
        'return_format' => 'url',
        'preview_size'  => 'thumbnail',
        'wrapper'       => ['width' => '30'],
      ],
      [
        'label'   => $link_label,
        'name'    => 'link',
        'type'    => $link_type,
        'wrapper' => ['width' => '70'],
      ],
    ],
  ];

  $fields = [];

  foreach ($manager_types as $manager) {
    $fields[] = [
      'label'     => $manager['label'],
      'name'      => 'tab-' . $manager['slug'],
      'type'      => 'tab',
      'placement' => 'top',
      'endpoint'  => 0,
    ];

    $fields[] = [
      'label'      => $manager['label'],
      'name'       => $manager['slug'],
      'type'       => 'group',
      'layout'     => 'block',
      'sub_fields' => [
        [
          'label'   => 'Role Label',
          'name'    => 'type-label',
          'type'    => 'text',
          'wrapper' => ['width' => '33'],
        ],
        [
          'label'   => 'Name',
          'name'    => 'name',
          'type'    => 'text',
          'wrapper' => ['width' => '33'],
        ],
        [
          'label'   => 'Position',
          'name'    => 'position',
          'type'    => 'text',
          'wrapper' => ['width' => '33'],
        ],
        [
          'label'         => 'Photo',
          'name'          => 'image',
          'type'          => 'image',
          'return_format' => 'id',
          'preview_size'  => 'thumbnail',
        ],
        $contact_group('Phone', 'Phone Number'),
        $contact_group('Email', 'Email Address'),
        $contact_group('Schedule', 'Schedule Text'),
        [
          'label'         => 'Send Message Button',
          'name'          => 'send-message',
          'type'          => 'link',
          'return_format' => 'array',
        ],
      ],
    ];
  }

  ACFComposer::registerFieldGroup([
    'name'     => 'managers_options',
    'title'    => 'Managers Options',
    'fields'   => $fields,
    'location' => [
      [
        [
          'param'    => 'options_page',
          'operator' => '==',
          'value'    => 'theme-options-managers',
        ],
      ],
    ],
  ]);
});
