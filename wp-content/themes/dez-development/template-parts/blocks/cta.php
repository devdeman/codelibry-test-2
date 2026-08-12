<?php

$image = get_array_value($args, 'cta-image', get('cta-image'));
$text = get_array_value($args, 'cta-text', get('cta-text'));
$buttons = get_array_value($args, 'cta-buttons', get('cta-buttons'));

if (!$image && !$text) {
  return;
}

?>

<section class="hero cta | section">
  <div class="container-lg cover">
    <div class="cta__inner">

      <?php if ($image): ?>
        <figure>
          <?php echo wp_get_attachment_image($image, 'full', false, [
            'loading' => 'lazy',
            'class' => 'hero__image'
          ]); ?>
        </figure>
      <?php endif; ?>

      <?php if ($text): ?>
        <div class="cta__content">
          <?php echo wp_kses_post($text); ?>
        </div>
      <?php endif; ?>

      <?php get_template_part('template-parts/blocks/parts/buttons', null, [
        'buttons' => $buttons,
      ]); ?>

    </div>
  </div>
</section>