<?php

$post_id   = get_array_value($args, 'post_id', get_the_ID());
$show_location_btn   = get_array_value($args, 'show_location_btn', false);
$title     = get_the_title($post_id);
$permalink = get_permalink($post_id);
$thumb_id  = get_post_thumbnail_id($post_id);

$status_terms = get_the_terms($post_id, 'community-status');
$status       = !empty($status_terms) && !is_wp_error($status_terms) ? $status_terms[0] : null;

$city_terms = get_the_terms($post_id, 'community-city');
$city       = !empty($city_terms) && !is_wp_error($city_terms) ? $city_terms[0] : null;

$homes_count    = (int) get_post_meta($post_id, '_community_homes_count', true);
$min_price      = get_post_meta($post_id, '_community_min_price', true);
$formatted_price = $min_price ? '$' . round((int) $min_price / 1000) . 'k' : '';

$location = get_field('community-location', $post_id);
$has_location = $location && !empty($location['lat']) && !empty($location['lng']);

?>

<article class="community-card js-map-card" data-id="<?php echo esc_attr($post_id); ?>">
  <?php if ($has_location && $show_location_btn): ?>
    <button class="property-card__map-focus js-map-focus" type="button" aria-label="<?php esc_attr_e('Show on map', 'codelibry'); ?>">
      <?php echo get_inline_svg('point-location'); ?>
    </button>
  <?php endif; ?>
  <a href="<?php echo esc_url($permalink); ?>" class="community-card__link" aria-label="<?php echo esc_attr($title); ?>">

    <div class="community-card__image">
      <?php if ($thumb_id): ?>
        <?php echo wp_get_attachment_image($thumb_id, 'full', false, ['loading' => 'lazy']); ?>
      <?php else: ?>
        <div class="community-card__image-placeholder"></div>
      <?php endif; ?>
    </div>

    <div class="community-card__body">

      <div>
        <?php if ($status): ?>
          <span class="community-card__status" data-slug="<?php echo esc_attr($status->slug); ?>"><?php echo esc_html($status->name); ?></span>
        <?php endif; ?>
        <h3 class="community-card__title"><?php echo esc_html($title); ?></h3>
        <div class="community-card__info">
          <?php if ($city): ?>
            <p class="community-card__city"><?php echo esc_html($city->name); ?></p>
          <?php endif; ?>
          <?php if ($formatted_price): ?>
            <p class="community-card__from">· From <?php echo esc_html($formatted_price); ?></p>
          <?php endif; ?>
        </div>
        <?php if ($homes_count > 0): ?>
          <div class="community-card__meta">
            <span class="community-card__homes">
              <?php echo esc_html($homes_count . ' homes'); ?>
            </span>
          </div>
        <?php endif; ?>
      </div>

      <span class="button button--text-arrow"><?php esc_html_e('Visit Community', 'codelibry'); ?></span>
    </div>

  </a>
</article>