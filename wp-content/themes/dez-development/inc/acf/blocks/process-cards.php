<?php

function codelibry_acf_fields_process_cards(): array
{
  return array_merge(
    codelibry_acf_fields_shared_label('process-cards'),
    codelibry_acf_fields_shared_title('process-cards'),
    [
      [
        'label'        => 'Cards list',
        'name'         => 'process-cards-list',
        'type'         => 'repeater',
        'layout'       => 'block',
        'button_label' => 'Add Cards',
        'min'          => 3,
        'max'          => 4,
        'sub_fields'   => [
          [
            'label'    => 'Title',
            'name'     => 'title',
            'type'     => 'text',
            'required' => 0,
            'wrapper'  => ['width' => '50'],
          ],
          [
            'label'   => 'Numbered headings',
            'name'    => 'numbered-headings',
            'type'    => 'true_false',
            'ui'      => 1,
            'wrapper' => ['width' => '50'],
          ],
          [
            'label'    => 'Text',
            'name'     => 'text',
            'type'         => 'textarea',
            'rows'         => 4,
            'new_lines'    => 'br',
            'required' => 0,
            'wrapper'  => ['width' => '50'],
          ],
          [
            'label'         => 'Image',
            'name'          => 'image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'required'      => 0,
            'wrapper'  => ['width' => '50'],
          ],
        ],
      ],
    ]
  );
}
