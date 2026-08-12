<?php

get_header();

if (!have_posts()) {
  get_footer();
  return;
}

while (have_posts()):
  the_post();

  $hero        = get_field('community-hero');
  $description = get_field('community-description');
  $highlights  = get_field('community-highlights');
  $schools     = get_field('community-schools');

  $hero_image = $hero['image'] ?? null;
  $hero_label = $hero['label'] ?? '';
  $hero_text  = $hero['text']  ?? '';

  $desc_label = $description['label'] ?? '';
  $desc_title = $description['title'] ?? '';
  $desc_text  = $description['text']  ?? '';
  $tags       = $description['tags']  ?? [];

  $title = get_the_title();

?>

  <?php
  // Fallback chain: ACF hero image → post thumbnail → Theme Options placeholder
  $display_image = $hero_image
    ?: get_post_thumbnail_id()
    ?: get_field('community-hero-placeholder', 'option');
  ?>
  <section class="community-hero">
    <?php if ($display_image): ?>
      <div class="community-hero__image">
        <?php echo wp_get_attachment_image($display_image, 'full', false, [
          'loading'       => false,
          'decoding'      => 'sync',
          'fetchpriority' => 'high',
        ]); ?>
      </div>
    <?php endif; ?>
    <div class="container-lg">
      <div class="community-hero__content">
        <?php if ($hero_label): ?>
          <p class="community-hero__label"><?php echo esc_html($hero_label); ?></p>
        <?php endif; ?>
        <h1 class="community-hero__title"><?php echo esc_html($title); ?></h1>
        <?php if ($hero_text): ?>
          <div class="community-hero__text"><?php echo wp_kses_post($hero_text); ?></div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php if ($desc_label || $desc_title || $desc_text || !empty($tags)): ?>
    <section class="community-living | section">
      <div class="container-lg">
        <div class="community-living__inner">
          <div class="community-living__content">
            <?php if ($desc_label): ?>
              <p class="community-living__label"><?php echo esc_html($desc_label); ?></p>
            <?php endif; ?>
            <?php if ($desc_title): ?>
              <h2 class="community-living__title"><?php echo esc_html($desc_title); ?></h2>
            <?php endif; ?>
            <?php if ($desc_text): ?>
              <div class="community-living__text"><?php echo wp_kses_post($desc_text); ?></div>
            <?php endif; ?>
          </div>
          <?php if (!empty($tags)): ?>
            <div class="community-living__badges">
              <?php foreach ($tags as $tag_item):
                $tag = $tag_item['tag'] ?? '';
                if (!$tag) continue;
              ?>
                <span class="community-badge"><?php echo esc_html($tag); ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php
  $has_highlights = !empty($highlights['label']) || !empty($highlights['title']) || !empty($highlights['items']);
  $has_schools    = !empty($schools['label'])    || !empty($schools['title'])    || !empty($schools['items']);
  ?>
  <?php if ($has_highlights || $has_schools): ?>
    <section class="community-details | section">
      <div class="container-lg">
        <div class="community-details__inner">

          <?php if ($has_highlights): ?>
            <div class="community-details__col">
              <?php if (!empty($highlights['label'])): ?>
                <p class="community-details__label"><?php echo esc_html($highlights['label']); ?></p>
              <?php endif; ?>
              <?php if (!empty($highlights['title'])): ?>
                <h3 class="community-details__title"><?php echo esc_html($highlights['title']); ?></h3>
              <?php endif; ?>
              <?php if (!empty($highlights['items'])): ?>
                <ul class="community-details__list">
                  <?php foreach ($highlights['items'] as $item): ?>
                    <li><?php echo get_inline_svg('MapPinArea') ?><?php echo esc_html($item['text']); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <?php if ($has_schools): ?>
            <div class="community-details__col">
              <?php if (!empty($schools['label'])): ?>
                <p class="community-details__label"><?php echo esc_html($schools['label']); ?></p>
              <?php endif; ?>
              <?php if (!empty($schools['title'])): ?>
                <h3 class="community-details__title"><?php echo esc_html($schools['title']); ?></h3>
              <?php endif; ?>
              <?php if (!empty($schools['items'])): ?>
                <ul class="community-details__list">
                  <?php foreach ($schools['items'] as $item): ?>
                    <li><?php echo get_inline_svg('MapPinArea') ?><?php echo esc_html($item['text']); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php
  $cards_grid = get_field('community-cards-grid');
  if (!empty($cards_grid['cards-grid-posts'])):
    get_template_part('template-parts/blocks/cards-grid', null, $cards_grid);
  endif;
  ?>

<?php endwhile; ?>

<?php get_footer(); ?>