<?php

function codelibry_acf_fields_cta_single_property(): array
{
  return array_merge(
    codelibry_acf_fields_shared_text('cta-single-property'),
    codelibry_acf_fields_shared_buttons('cta-single-property'),
    codelibry_acf_fields_shared_image('cta-single-property'),
  );
}
