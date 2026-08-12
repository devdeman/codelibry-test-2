<?php

$post_id   = get_array_value($args, 'post_id', get_the_ID());
$show_location_btn = get_array_value($args, 'show_location_btn', false);
$title     = get_the_title($post_id);
$permalink = get_permalink($post_id);
$thumb_id  = get_post_thumbnail_id($post_id);

$info    = get_field('property-info', $post_id) ?: [];
$price   = $info['price']   ?? '';
$baths   = $info['baths']   ?? '';
$sqft    = $info['sqft']    ?? '';
$address = $info['address'] ?? '';

$status_terms = get_the_terms($post_id, 'property-status');
$status       = !empty($status_terms) && !is_wp_error($status_terms) ? $status_terms[0] : null;

$beds_terms = get_the_terms($post_id, 'property-beds');
$beds       = !empty($beds_terms) && !is_wp_error($beds_terms) ? $beds_terms[0] : null;

$area_terms = get_the_terms($post_id, 'property-area');
$area       = !empty($area_terms) && !is_wp_error($area_terms) ? $area_terms[0] : null;

$location = get_field('property-location', $post_id);
$has_location = $location && !empty($location['lat']) && !empty($location['lng']);

?>

<article class="property-card js-map-card" data-id="<?php echo esc_attr($post_id); ?>">
  <?php if ($has_location && $show_location_btn): ?>
    <button class="property-card__map-focus js-map-focus" type="button" aria-label="<?php esc_attr_e('Show on map', 'codelibry'); ?>">
      <?php echo get_inline_svg('point-location'); ?>
    </button>
  <?php endif; ?>

  <a href="<?php echo esc_url($permalink); ?>" class="property-card__link" aria-label="<?php echo esc_attr($title); ?>">


    <div class="property-card__image">
      <?php if ($thumb_id): ?>
        <?php echo wp_get_attachment_image($thumb_id, 'large', false, ['loading' => 'lazy']); ?>
      <?php else: ?>
        <div class="property-card__image-placeholder"></div>
      <?php endif; ?>
    </div>

    <div class="property-card__body">
      <div>
        <?php if ($status): ?>
          <span class="property-card__status" data-slug="<?php echo esc_attr($status->slug); ?>">
            <?php echo esc_html($status->name); ?>
          </span>
        <?php endif; ?>
        <h3 class="property-card__title"><?php echo esc_html($title); ?></h3>

        <?php if ($address): ?>
          <p class="property-card__address"><?php echo esc_html($address); ?></p>
        <?php endif; ?>
      </div>

      <div>
        <?php if ($area): ?>
          <span class="property-card__area">
            <?php echo get_inline_svg('MapPinLine') ?>
            <?php echo esc_html($area->name); ?>
          </span>
        <?php endif; ?>

        <?php if ($price): ?>
          <span class="property-card__price">$<?php echo esc_html($price); ?></span>
        <?php endif; ?>

        <ul class="property-card__specs">
          <?php if ($beds): ?>
            <li><span><?php echo (int) $beds->name; ?></span>Beds</li>
          <?php endif; ?>
          <?php if ($baths): ?>
            <li><span><?php echo esc_html($baths); ?></span>Baths</li>
          <?php endif; ?>
          <?php if ($sqft): ?>
            <li><span><?php echo number_format((float) $sqft); ?></span>sqft</li>
          <?php endif; ?>
        </ul>

        <div class="property-card__footer">
          <span class="property-card__cta button button--text-arrow">
            <?php esc_html_e('View Home', 'codelibry'); ?>
          </span>
        </div>
      </div>

    </div>
  </a>
</article>