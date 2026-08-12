<?php

function codelibry_acf_fields_testimonials_slider(): array
{
  return array_merge(
    codelibry_acf_fields_shared_text('testimonials-slider'),
    codelibry_acf_fields_shared_post_object('testimonials-slider'),
  );
}
