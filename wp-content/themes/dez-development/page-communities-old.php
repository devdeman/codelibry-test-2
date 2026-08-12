<?php

/**
 * Template Name: Communities Old
 */

get_header();

global $wp_query;

$hero_image = get('hero-image', true);
$hero_label = get('hero-label', true);
$hero_title = get('hero-title', true);
$hero_text  = get('hero-text', true);

$total = $wp_query->found_posts;

?>

<section class="community-archive-hero">
  <?php if ($hero_image): ?>
    <div class="community-archive-hero__image">
      <?php echo wp_get_attachment_image($hero_image, 'full', false, [
        'loading'       => false,
        'decoding'      => 'sync',
        'fetchpriority' => 'high',
      ]); ?>
    </div>
  <?php endif; ?>
  <div class="container-lg">
    <div class="community-archive-hero__content">
      <?php if ($hero_label): ?>
        <p class="community-archive-hero__label"><?php echo esc_html($hero_label); ?></p>
      <?php endif; ?>
      <?php if ($hero_title): ?>
        <h1 class="community-archive-hero__title"><?php echo esc_html($hero_title); ?></h1>
      <?php endif; ?>
      <?php if ($hero_text): ?>
        <p class="community-archive-hero__text"><?php echo esc_html($hero_text); ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>
<h1>jhj</h1>

<?php get_footer(); ?>