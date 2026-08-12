<?php

function codelibry_acf_fields_numbers(): array
{
  return array_merge(
    codelibry_acf_fields_shared_numbers('numbers'),
  );
}
