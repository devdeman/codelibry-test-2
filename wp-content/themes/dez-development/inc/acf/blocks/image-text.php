<?php

function codelibry_acf_fields_image_text(): array
{
    return array_merge(
        codelibry_acf_fields_shared_text('image-text'),
        codelibry_acf_fields_shared_numbers('image-text'),
        codelibry_acf_fields_shared_buttons('image-text'),
        codelibry_acf_fields_shared_image('image-text'),
    );
}
