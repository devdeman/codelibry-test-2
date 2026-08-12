<?php

$label    = get_array_value($args, 'testimonials-label', get('testimonials-label'));
$title    = get_array_value($args, 'testimonials-title', get('testimonials-title'));
$post_ids = get_array_value($args, 'testimonials-posts', get('testimonials-posts'));

if (empty($post_ids)) {
  return;
}

$testimonials = get_posts([
  'post_type'      => 'testimonials',
  'posts_per_page' => -1,
  'post__in'       => (array) $post_ids,
  'orderby'        => 'post__in',
  'post_status'    => 'publish',
]);

if (empty($testimonials)) {
  return;
}

$total   = count($testimonials);
$initial = min(9, $total);

?>

<section class="testimonials-grid | section js-testimonials">
  <div class="container-lg">

    <?php if ($label || $title): ?>
      <div class="testimonials-grid__header">
        <?php if ($label): ?>
          <p class="testimonials-grid__label"><?php echo esc_html($label); ?></p>
        <?php endif; ?>
        <?php if ($title): ?>
          <h2 class="testimonials-grid__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="testimonials-grid__cards">
      <?php foreach ($testimonials as $t):
        $author_name = get_field('author-name', $t->ID);
        $content     = get_field('content', $t->ID);
      ?>
        <div class="testimonials-grid__card testimonials__card">
          <div>
            <div class="testimonials-grid__quote"><?php echo get_inline_svg('quotation-marks') ?></div>
            <?php if ($content): ?>
              <div class="testimonials-grid__text"><?php echo wp_kses_post($content); ?></div>
            <?php endif; ?>
          </div>
          <div class="testimonials-grid__footer">
            <?php if ($author_name): ?>
              <h3 class="testimonials-grid__author"><?php echo esc_html($author_name); ?></h3>
            <?php endif; ?>
            <div class="testimonials-grid__stars" aria-label="<?php esc_attr_e('5 stars', 'codelibry'); ?>"><?php echo get_inline_svg('stars') ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ($total > 9): ?>
      <div class="testimonials-grid__more">
        <button class="button js-testim-more" type="button" data-text="<?php echo esc_attr__('Load More Reviews', 'codelibry'); ?>">
          <span><?php esc_html_e('Load More Reviews', 'codelibry'); ?></span>
        </button>
        <p class="testimonials-grid__counter js-testim-counter">
          <?php printf(
            esc_html__('Showing %1$d of %2$d reviews', 'codelibry'),
            $initial,
            $total
          ); ?>
        </p>
      </div>
    <?php endif; ?>

  </div>
</section>