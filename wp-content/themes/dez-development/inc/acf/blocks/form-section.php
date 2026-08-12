<?php

function codelibry_acf_fields_form_section(): array
{
    $contact_group = fn(string $label, string $name, string $link_label, string $link_type = 'text') => [
        'label'      => $label,
        'name'       => $name,
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
                'label'         => $link_label,
                'name'          => 'link',
                'type'          => $link_type,
                'return_format' => 'array',
                'wrapper'       => ['width' => '70'],
            ],
        ],
    ];

    return array_merge(
        codelibry_acf_fields_shared_text('form-section'),
        codelibry_acf_fields_shared_buttons('form-section'),
        [
            [
                'label'        => 'Show Contact Info',
                'name'         => 'form-section-show-contacts',
                'type'         => 'true_false',
                'default_value' => 0,
                'ui'           => 1,
                'ui_on_text'   => 'Yes',
                'ui_off_text'  => 'No',
                'instructions' => 'Enable to show address, phone, email and hours on the left side.',
            ],
            $contact_group('Address', 'form-section-address', 'Address (text + Google Maps URL)', 'link'),
            $contact_group('Phone',   'form-section-phone',   'Phone Number'),
            $contact_group('Email',   'form-section-email',   'Email Address'),
            $contact_group('Hours',   'form-section-hours',   'Hours Text'),
            [
                'label'         => 'Form',
                'name'          => 'form-section-form',
                'type'          => 'post_object',
                'post_type'     => ['wpcf7_contact_form'],
                'return_format' => 'id',
                'multiple'      => 0,
                'allow_null'    => 1,
                'ui'            => 1,
                'required'      => 0,
            ],
        ]
    );
}

/*
 * ACFComposer generates field keys at runtime, so conditional_logic cannot reference
 * them statically. Instead we capture the toggle key via acf/prepare_field (admin only)
 * and inject conditional_logic into the dependent fields on the fly.
 */
(function () {
    $toggle_key = null;

    add_filter('acf/prepare_field/name=form-section-show-contacts', function ($field) use (&$toggle_key) {
        $toggle_key = $field['key'];
        return $field;
    });

    $deps = [
        'form-section-address',
        'form-section-phone',
        'form-section-email',
        'form-section-hours',
    ];

    foreach ($deps as $dep_name) {
        add_filter("acf/prepare_field/name={$dep_name}", function ($field) use (&$toggle_key) {
            if ($toggle_key) {
                $field['conditional_logic'] = [
                    [['field' => $toggle_key, 'operator' => '==', 'value' => '1']],
                ];
            }
            return $field;
        });
    }
})();
