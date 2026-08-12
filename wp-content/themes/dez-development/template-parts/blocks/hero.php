<?php

$image = get_array_value($args, 'hero-image', get('hero-image'));
$text = get_array_value($args, 'hero-text', get('hero-text'));

if (!$image && !$text) {
  return;
}

?>

<section class="hero | section">
  <div class="container-lg cover">
    <div class="hero__inner">

      <?php if ($image): ?>
        <figure class="hero__media">
          <?php echo wp_get_attachment_image($image, 'full', false, [
            'loading' => false,
            'decoding' => 'sync',
            'fetchpriority' => 'high',
            'class' => 'hero__image'
          ]); ?>
        </figure>
      <?php endif; ?>

      <?php if ($text): ?>
        <div class="hero__content">
          <?php echo wp_kses_post($text); ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>