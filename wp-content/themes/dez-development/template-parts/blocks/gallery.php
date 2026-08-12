<?php

$label    = get_array_value($args, 'gallery-label', get('gallery-label'));
$title    = get_array_value($args, 'gallery-title', get('gallery-title'));
$per_page = (int) get_array_value($args, 'gallery-per-page', get('gallery-per-page')) ?: 7;

$total_query = new WP_Query([
  'post_type'      => 'gallery',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
  'fields'         => 'ids',
]);
$total_items = $total_query->found_posts;
wp_reset_postdata();

if ($total_items === 0 && !$label && !$title) {
  return;
}

$initial_query = new WP_Query([
  'post_type'      => 'gallery',
  'posts_per_page' => $per_page,
  'post_status'    => 'publish',
  'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
]);
$initial_count = $initial_query->post_count;
$has_more      = $total_items > $initial_count;

$categories = get_terms(['taxonomy' => 'gallery-category', 'hide_empty' => true]);
$nonce      = wp_create_nonce('gallery_filter_nonce');

?>

<section class="gallery-block section">
  <div class="container-lg">

    <div class="gallery-block__top">
      <?php if ($label || $title): ?>
        <div class="gallery-block__header">
          <?php if ($label): ?>
            <p class="gallery-block__label"><?php echo esc_html($label); ?></p>
          <?php endif; ?>
          <?php if ($title): ?>
            <h2 class="gallery-block__title"><?php echo esc_html($title); ?></h2>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($categories) && !is_wp_error($categories)): ?>
        <div class="gallery-block__filter">
          <button class="gallery-block__filter-btn is-active" data-category="" type="button">
            All
          </button>
          <?php foreach ($categories as $cat): ?>
            <button class="gallery-block__filter-btn" data-category="<?php echo esc_attr($cat->slug); ?>" type="button">
              <?php echo esc_html($cat->name); ?>
            </button>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="gallery-block__grid js-gallery-grid"
      data-per-page="<?php echo esc_attr($per_page); ?>"
      data-nonce="<?php echo esc_attr($nonce); ?>"
      data-offset="<?php echo esc_attr($initial_count); ?>"
      data-category="">
      <?php
      if ($initial_query->have_posts()):
        while ($initial_query->have_posts()):
          $initial_query->the_post();
          $image_id = get_field('gallery-image', get_the_ID()) ?: get_post_thumbnail_id(get_the_ID());
          if (!$image_id) continue;
          get_template_part('template-parts/parts/gallery-item', null, ['image_id' => (int) $image_id]);
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </div>

    <?php if ($total_items > 0): ?>
      <div class="gallery-block__footer js-gallery-footer" <?php echo !$has_more ? ' hidden' : ''; ?>>
        <button class="button js-gallery-load-more" type="button" data-text="Load More Photos"><span>Load More Photos</span></button>
      </div>
      <p class="gallery-block__count js-gallery-count">
        Showing <?php echo esc_html($initial_count); ?> of <?php echo esc_html($total_items); ?> photos
      </p>
    <?php endif; ?>

  </div>
</section>