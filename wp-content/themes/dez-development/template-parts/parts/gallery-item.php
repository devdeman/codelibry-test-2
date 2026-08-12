<?php

$image_id = isset($args['image_id']) ? (int) $args['image_id'] : 0;
if (!$image_id) return;

$full_src = wp_get_attachment_image_src($image_id, 'full');
$full_url = $full_src ? $full_src[0] : '';

?>
<div class="gallery-block__item" data-full-src="<?php echo esc_url($full_url); ?>">
  <?php echo wp_get_attachment_image($image_id, 'full', false, [
    'loading' => 'lazy',
    'class'   => 'gallery-block__img',
  ]); ?>
  <button class="gallery-block__expand" type="button" aria-label="View full size">
    <span class="gallery-block__expand-icon">
      <?php echo get_inline_svg('ArrowsOutSimple'); ?>
    </span>
  </button>
</div>