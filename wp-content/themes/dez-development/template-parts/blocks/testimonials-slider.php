<?php

$text = get_array_value($args, 'testimonials-slider-text', get('testimonials-slider-text'));
$testimonials = get_array_value($args, 'testimonials-slider-post-object', get('testimonials-slider-post-object'));

if (!$testimonials) {
  return;
}

?>

<section class="testimonials-slider | section">
  <div class="container-lg">
    <div class="testimonials-slider__inner">

      <div class="swiper testimonials-slider__slider">
        <?php if ($text): ?>
          <div class="testimonials-slider__text">
            <?php echo wp_kses_post($text); ?>
          </div>
        <?php endif; ?>

        <div class="testimonials-slider__header">
          <?php echo get_inline_svg('quotation-marks') ?>
          <div>
            <div class="testimonials-slider__header--box">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
            <div class="testimonials-slider__pagination"></div>
          </div>
        </div>

        <div class="swiper-wrapper">
          <?php foreach ($testimonials as $testimonial_id): ?>
            <?php
            $author_name = get_field('author-name', $testimonial_id);
            $content = get_field('content', $testimonial_id);
            $image_id = get_field('image', $testimonial_id);
            $image_html = $image_id ? wp_get_attachment_image($image_id, 'full', false, ['loading' => 'lazy']) : '';
            ?>
            <div class="swiper-slide">
              <div class="testimonials-slider__content">

                <?php if ($content): ?>
                  <?php echo $content; ?>
                <?php endif; ?>
                <?php if ($author_name): ?>
                  <div class="testimonials-slider__author">
                    <h3><?php echo esc_html($author_name); ?></h3>
                    <?php echo get_inline_svg('stars') ?>
                  </div>
                <?php endif; ?>
              </div>
              <div class="testimonials-slider__image">
                <?php echo $image_html; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>



      </div>
    </div>
  </div>
</section>