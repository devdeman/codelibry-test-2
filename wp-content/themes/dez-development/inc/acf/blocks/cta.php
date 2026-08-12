<?php

function codelibry_acf_fields_cta(): array
{
  return array_merge(
    codelibry_acf_fields_shared_text('cta'),
    codelibry_acf_fields_shared_buttons('cta'),
    codelibry_acf_fields_shared_image('cta'),
  );
}
