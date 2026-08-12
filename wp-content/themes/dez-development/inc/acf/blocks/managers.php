<?php

function codelibry_acf_fields_managers(): array
{
  return array_merge(
    codelibry_acf_fields_shared_text('managers'),
    codelibry_acf_fields_shared_buttons('managers'),
    [
      [
        'label'         => 'Manager',
        'name'          => 'manager-type',
        'type'          => 'select',
        'choices'       => [
          'sales-director'               => 'Sales Director',
          'sales-agent'                  => 'Sales Agent',
          'realtor-relations-manager'    => 'Realtor Relations Manager',
          'warranty-after-sales-manager' => 'Warranty & After-Sales Manager',
        ],
        'default_value' => 'sales-agent',
        'allow_null'    => 1,
        'ui'            => 1,
      ],
    ]
  );
}
