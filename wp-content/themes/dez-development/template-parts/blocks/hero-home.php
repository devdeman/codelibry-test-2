<?php

$image        = get_array_value($args, 'hero-home-image', get('hero-home-image'));
$image_mobile = get_array_value($args, 'hero-home-image-mobile', get('hero-home-image-mobile'));
$text         = get_array_value($args, 'hero-home-text', get('hero-home-text'));

if (!$image && !$image_mobile && !$text) {
  return;
}

$homes_url = get_post_type_archive_link('property');

$hs_fields = [
  [
    'param'       => 'city',
    'label'       => 'City',
    'placeholder' => 'Any City',
    'taxonomy'    => 'property-city',
  ],
  [
    'param'       => 'area',
    'label'       => 'Communities',
    'placeholder' => 'Any Communities',
    'taxonomy'    => 'property-area',
  ],
  [
    'param'       => 'price_range',
    'label'       => 'Price',
    'placeholder' => 'Any Price',
    'taxonomy'    => 'property-price-range',
  ],
  [
    'param'       => 'beds',
    'label'       => 'Bedrooms',
    'placeholder' => 'Any Bedrooms',
    'taxonomy'    => 'property-beds',
  ],
];

?>

<section class="hero hero-home | section">
  <div class="container-lg cover">
    <div class="hero__inner">

      <?php if ($image): ?>
        <figure class="hero__media hero__media--desktop">
          <?php echo wp_get_attachment_image($image, 'full', false, [
            'loading'       => false,
            'decoding'      => 'sync',
            'fetchpriority' => 'high',
            'class'         => 'hero__image'
          ]); ?>
        </figure>
      <?php endif; ?>

      <?php
      $mobile_image = $image_mobile ?: $image;
      if ($mobile_image):
      ?>
        <figure class="hero__media hero__media--mobile">
          <?php echo wp_get_attachment_image($mobile_image, 'full', false, [
            'loading'       => false,
            'decoding'      => 'sync',
            'fetchpriority' => 'high',
            'class'         => 'hero__image'
          ]); ?>
        </figure>
      <?php endif; ?>

      <?php if ($text): ?>
        <div class="hero__content">
          <?php echo wp_kses_post($text); ?>
        </div>
      <?php endif; ?>

      <div class="hero__search js-hero-search" data-action="<?php echo esc_url($homes_url); ?>">
        <div class="hero__search-fields">
          <?php foreach ($hs_fields as $i => $hsf):
            $terms   = get_terms(['taxonomy' => $hsf['taxonomy'], 'hide_empty' => false]);
            $mask_id = 'hs-mask-' . esc_attr($hsf['param']);
          ?>
            <div class="hero__search-field js-hero-field" data-param="<?php echo esc_attr($hsf['param']); ?>" data-value="">
              <span class="hero__search-label"><?php echo esc_html($hsf['label']); ?></span>
              <button class="hero__search-trigger js-hero-trigger" type="button">
                <span class="hero__search-value js-hero-val"><?php echo esc_html($hsf['placeholder']); ?></span>
                <svg class="hero__search-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                  <mask id="<?php echo $mask_id; ?>" width="24" height="24" x="0" y="0" maskUnits="userSpaceOnUse" style="mask-type:alpha">
                    <path fill="#d9d9d9" d="M0 0h24v24H0z" />
                  </mask>
                  <g mask="url(#<?php echo $mask_id; ?>)">
                    <path fill="currentColor" d="m12 15.4-6-6L7.4 8l4.6 4.6L16.6 8 18 9.4z" />
                  </g>
                </svg>
              </button>
              <?php if (!is_wp_error($terms) && !empty($terms)): ?>
                <div class="hero__search-dropdown js-hero-dropdown">
                  <ul class="hero__search-list">
                    <li class="hero__search-item is-active" data-value=""><?php echo esc_html($hsf['placeholder']); ?></li>
                    <?php foreach ($terms as $term): ?>
                      <li class="hero__search-item" data-value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
        <button class="hero__search-btn js-hero-submit" type="button" data-text="<?php echo esc_attr__('Search Homes', 'codelibry'); ?>">
          <span><?php esc_html_e('Search Homes', 'codelibry'); ?></span>
        </button>
      </div>

    </div>
  </div>
</section>