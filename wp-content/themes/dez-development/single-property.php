<?php

get_header();

if (!have_posts()) {
  get_footer();
  return;
}

while (have_posts()):
  the_post();

  $post_id    = get_the_ID();
  $title      = get_the_title();

  // Fields
  $gallery     = get_field('property-gallery')     ?: [];
  $info        = get_field('property-info')         ?: [];
  $buttons     = get_field('property-buttons')      ?: [];
  $description = get_field('property-description')  ?: [];
  $payment     = get_field('property-payment')      ?: [];
  $floor_plan  = get_field('property-floor-plan')   ?: [];

  // Spec groups
  $spec_property = get_field('spec-property') ?: [];
  $spec_features = get_field('spec-features') ?: [];
  $spec_home     = get_field('spec-home')     ?: [];
  $spec_hoa      = get_field('spec-hoa')      ?: [];

  // Reusable blocks
  $testimonials_id = get_field('property-testimonials');
  $cta_id          = get_field('property-cta-single-property');

  // Info fields
  $address        = $info['address']        ?? '';
  $price          = $info['price']          ?? '';
  $baths          = $info['baths']          ?? '';
  $sqft           = $info['sqft']           ?? '';
  $floor_plan_name = $info['floor-plan-name'] ?? '';

  // Taxonomies
  $status_terms  = get_the_terms($post_id, 'property-status');
  $status        = !empty($status_terms) && !is_wp_error($status_terms) ? $status_terms[0] : null;

  $area_terms    = get_the_terms($post_id, 'property-area');
  $area          = !empty($area_terms) && !is_wp_error($area_terms) ? $area_terms[0] : null;

  $beds_terms    = get_the_terms($post_id, 'property-beds');
  $beds          = !empty($beds_terms) && !is_wp_error($beds_terms) ? $beds_terms[0] : null;

  $garage_terms  = get_the_terms($post_id, 'property-garage');
  $garage        = !empty($garage_terms) && !is_wp_error($garage_terms) ? $garage_terms[0] : null;

  // Manager
  $manager = get('realtor-relations-manager', true);

  $has_multiple_images = count($gallery) > 1;

?>

  <!-- ===== HERO ===== -->
  <section class="property-hero">
    <?php if (!empty($gallery)): ?>
      <?php if ($has_multiple_images): ?>

        <div class="swiper property-hero__slider">
          <div class="swiper-wrapper">
            <?php foreach ($gallery as $img_id): ?>
              <div class="swiper-slide">
                <?php echo wp_get_attachment_image($img_id, 'full', false, [
                  'loading'       => false,
                  'decoding'      => 'sync',
                  'fetchpriority' => 'high',
                ]); ?>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="property-hero__overlay">
            <div class="container-lg">
              <div class="property-hero__content property-hero__overlay__content">
                <h1 class="property-hero__title"><?php echo esc_html($title); ?></h1>
                <?php if ($address): ?>
                  <p class="property-hero__address"><?php echo esc_html($address); ?></p>
                <?php endif; ?>
                <div class="property-hero__meta">
                  <div class="property-hero__box">
                    <?php if ($price): ?>
                      <span class="property-hero__price">$<?php echo esc_html($price); ?></span>
                    <?php endif; ?>
                    <div class="property-hero__specs">
                      <?php if ($beds): ?>
                        <span><?php echo (int) $beds->name; ?> Beds</span>
                      <?php endif; ?>
                      <?php if ($baths): ?>
                        <span><?php echo esc_html($baths); ?> Baths</span>
                      <?php endif; ?>
                      <?php if ($sqft): ?>
                        <span><?php echo number_format((float)$sqft); ?> sqft</span>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="property-hero__navs">
                    <div class="property-hero__nav">
                      <div class="swiper-button-prev"></div>
                      <div class="swiper-button-next"></div>
                    </div>
                    <div class="property-hero__pagination"></div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

      <?php else: ?>

        <div class="property-hero__single-image">
          <?php echo wp_get_attachment_image($gallery[0], 'full', false, [
            'loading'       => false,
            'decoding'      => 'sync',
            'fetchpriority' => 'high',
          ]); ?>

          <div class="property-hero__overlay">
            <div class="container-lg">
              <div class="property-hero__content property-hero__overlay__content">
                <h1 class="property-hero__title"><?php echo esc_html($title); ?></h1>
                <?php if ($address): ?>
                  <p class="property-hero__address"><?php echo esc_html($address); ?></p>
                <?php endif; ?>
                <div class="property-hero__meta">
                  <div class="property-hero__box">
                    <?php if ($price): ?>
                      <span class="property-hero__price">$<?php echo esc_html($price); ?></span>
                    <?php endif; ?>
                    <div class="property-hero__specs">
                      <?php if ($beds): ?>
                        <span><?php echo (int) $beds->name; ?> Beds</span>
                      <?php endif; ?>
                      <?php if ($baths): ?>
                        <span><?php echo esc_html($baths); ?> Baths</span>
                      <?php endif; ?>
                      <?php if ($sqft): ?>
                        <span><?php echo number_format((float)$sqft); ?> sqft</span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php endif; ?>
    <?php endif; ?>
  </section>

  <!-- ===== PROPERTY DETAIL ===== -->
  <section class="property-detail | section">
    <div class="container-lg">
      <div class="property-detail__inner">

        <div class="property-detail__main">
          <div class="property-detail__badges">
            <?php if ($status): ?>
              <span class="property-detail__badge property-detail__badge--status" data-status="<?php echo esc_attr($status->slug); ?>">
                <?php echo esc_html($status->name); ?>
              </span>
            <?php endif; ?>
            <?php if ($area): ?>
              <span class="property-detail__badge property-detail__badge--area">
                <?php echo get_inline_svg('MapPinLine') ?>
                <?php echo esc_html($area->name); ?>
              </span>
            <?php endif; ?>
          </div>

          <h2 class="property-detail__title"><?php echo esc_html($title); ?></h2>
          <?php if ($address): ?>
            <p class="property-detail__address"><?php echo esc_html($address); ?></p>
          <?php endif; ?>
          <?php if ($price): ?>
            <h4 class="property-detail__price">$<?php echo esc_html($price); ?></h4>
          <?php endif; ?>

          <ul class="property-detail__specs">
            <?php if ($beds): ?>
              <li>
                <h5><?php echo (int) $beds->name; ?></h5> Bedrooms
              </li>
            <?php endif; ?>
            <?php if ($baths): ?>
              <li>
                <h5><?php echo esc_html($baths); ?></h5> Bathrooms
              </li>
            <?php endif; ?>
            <?php if ($sqft): ?>
              <li>
                <h5><?php echo number_format((float)$sqft); ?></h5> Sq Ft
              </li>
            <?php endif; ?>
            <?php if ($garage): ?>
              <li>
                <h5><?php echo (int) $garage->name; ?></h5> Garage
              </li>
            <?php endif; ?>
            <?php if ($floor_plan_name): ?>
              <li>
                <h5><?php echo esc_html($floor_plan_name); ?></h5> Floor Plan
              </li>
            <?php endif; ?>
          </ul>

          <?php get_template_part('template-parts/blocks/parts/buttons', null, [
            'buttons' => $buttons,
          ]); ?>
        </div>

        <?php if ($manager): ?>
          <div class="property-detail__sidebar">
            <?php get_template_part('template-parts/blocks/parts/managers', null, [
              'manager' => $manager,
            ]); ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </section>

  <!-- ===== DESCRIPTION + PAYMENT ===== -->
  <?php
  $desc_label = $description['label'] ?? '';
  $desc_title = $description['title'] ?? '';
  $desc_text  = $description['text']  ?? '';
  $pay_label  = $payment['label']     ?? '';
  $pay_price  = $payment['price']     ?? '';
  $pay_details = $payment['details']  ?? [];
  $pay_calc   = $payment['calculator-link'] ?? null;
  ?>
  <?php if ($desc_label || $desc_title || $desc_text || $pay_price): ?>
    <section class="property-content | section">
      <div class="container-lg">
        <div class="property-content__inner">

          <div class="property-content__description">
            <?php if ($desc_label): ?>
              <p class="property-content__label"><?php echo esc_html($desc_label); ?></p>
            <?php endif; ?>
            <?php if ($desc_title): ?>
              <h3 class="property-content__title"><?php echo esc_html($desc_title); ?></h3>
            <?php endif; ?>
            <?php if ($desc_text): ?>
              <div class="property-content__text"><?php echo wp_kses_post($desc_text); ?></div>
            <?php endif; ?>
          </div>

          <?php if ($pay_price || !empty($pay_details)): ?>
            <div class="property-content__payment">
              <?php if ($pay_label): ?>
                <p class="property-payment__label"><?php echo esc_html($pay_label); ?></p>
              <?php endif; ?>
              <?php if ($pay_price): ?>
                <h4 class="property-payment__price">$<?php echo number_format((float)$pay_price); ?>
                  <span>/mo</span>
                </h4>
              <?php endif; ?>
              <?php if (!empty($pay_details)): ?>
                <div class="property-payment__details">
                  <?php foreach ($pay_details as $detail):
                    $amount = $detail['amount']      ?? '';
                    $desc   = $detail['description'] ?? '';
                    if (!$amount) continue;
                  ?>
                    <div class="property-payment__pill-group">
                      <span class="property-payment__pill"><?php echo esc_html($amount); ?></span>
                      <?php if ($desc): ?>
                        <p class="property-payment__pill-label"><?php echo esc_html($desc); ?></p>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <?php if (!empty($pay_calc['url'])): ?>
                <a href="<?php echo esc_url($pay_calc['url']); ?>" class="property-payment__calc button button--text-arrow">
                  <?php echo esc_html($pay_calc['title'] ?: __('Adjust with Financing Calculator', 'codelibry')); ?>
                </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ===== FLOOR PLAN ===== -->
  <?php
  $fp_floors = $floor_plan['floors']   ?? [];
  $fp_pdf    = $floor_plan['pdf-link'] ?? null;
  ?>
  <?php if (!empty($fp_floors)): ?>
    <section class="property-floor-plan | section">
      <div class="container-lg">

        <div class="property-floor-plan__box">
          <div>
            <?php if ($floor_plan_name): ?>
              <p class="property-floor-plan__label">
                <?php echo esc_html($floor_plan_name); ?> &middot; <?php esc_html_e('Floor Plan', 'codelibry'); ?>
              </p>
            <?php endif; ?>
            <h2 class="property-floor-plan__title"><?php esc_html_e('Floor Plan', 'codelibry'); ?></h2>
          </div>
          <div class="property-floor-plan__tabs" role="tablist">
            <?php foreach ($fp_floors as $i => $floor):
              $tab_name = $floor['tab-name'] ?? '';
              if (!$tab_name) continue;
            ?>
              <button
                class="property-floor-plan__tab<?php echo $i === 0 ? ' is-active' : ''; ?>"
                data-index="<?php echo esc_attr($i); ?>"
                data-name="<?php echo esc_attr($tab_name); ?>"
                data-sqft="<?php echo esc_attr($floor['sqft'] ?? ''); ?>"
                role="tab"
                aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"><?php echo esc_html($tab_name); ?></button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="property-floor-plan__panels">
          <?php foreach ($fp_floors as $i => $floor):
            $img_id  = $floor['image'] ?? null;
          ?>
            <div class="property-floor-plan__panel<?php echo $i === 0 ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr($i); ?>">
              <?php if ($img_id): ?>
                <?php echo wp_get_attachment_image($img_id, 'large', false, ['loading' => 'lazy']); ?>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="property-floor-plan__footer">
          <span class="property-floor-plan__footer-info js-floor-info">
            <?php
            $first = $fp_floors[0] ?? [];
            echo esc_html(($first['tab-name'] ?? '') . ($first['sqft'] ? ' · ' . number_format((float)$first['sqft']) . ' sqft' : ''));
            ?>
          </span>
          <?php if (!empty($fp_pdf['url'])): ?>
            <a href="<?php echo esc_url($fp_pdf['url']); ?>" class="property-floor-plan__pdf" target="_blank" rel="noopener">
              <?php echo esc_html($fp_pdf['title'] ?: __('Download Floor Plan PDF', 'codelibry')); ?>
              <?php echo get_inline_svg('download') ?>
            </a>
          <?php endif; ?>
        </div>

      </div>
    </section>
  <?php endif; ?>

  <!-- ===== SPECIFICATIONS ===== -->
  <?php
  $spec_groups = [
    ['label' => 'Property', 'data' => $spec_property, 'fields' => [
      'address' => 'Address',
      'community' => 'Community',
      'status' => 'Status',
      'floor-plan' => 'Floor Plan',
      'year-built' => 'Year Built',
      'lot-size' => 'Lot Size',
      'mls' => 'MLS #',
    ]],
    ['label' => 'Features', 'data' => $spec_features, 'fields' => [
      'kitchen' => 'Kitchen',
      'flooring' => 'Flooring',
      'heating' => 'Heating',
      'cooling' => 'Cooling',
      'exterior' => 'Exterior',
      'outdoor' => 'Outdoor',
      'windows' => 'Windows',
    ]],
    ['label' => 'Home', 'data' => $spec_home, 'fields' => [
      'total-sqft' => 'Total Sq Ft',
      'stories' => 'Stories',
      'bedrooms' => 'Bedrooms',
      'bathrooms' => 'Bathrooms',
      'garage' => 'Garage',
      'basement' => 'Basement',
    ]],
    ['label' => 'HOA &amp; Financials', 'data' => $spec_hoa, 'fields' => [
      'hoa' => 'HOA',
      'hoa-includes' => 'HOA Includes',
      'property-tax' => 'Property Tax',
      'school-district' => 'School District',
    ]],
  ];
  $has_specs = array_filter($spec_groups, fn($g) => !empty(array_filter($g['data'] ?? [])));
  ?>
  <?php if (!empty($has_specs)): ?>
    <section class="property-specs | section">
      <div class="container-lg">
        <p class="property-specs__label"><?php esc_html_e('Full Details', 'codelibry'); ?></p>
        <h2 class="property-specs__title"><?php esc_html_e('Specifications', 'codelibry'); ?></h2>
        <div class="property-specs__grid">
          <?php foreach ($spec_groups as $i => $group):
            $group_data = $group['data'] ?? [];
            $has_values = !empty(array_filter($group_data));
            if (!$has_values) continue;
          ?>
            <div class="property-specs__col">
              <h4 class="property-specs__col-title"><?php echo $group['label']; ?></h4>
              <div class="property-specs__list">
                <?php foreach ($group['fields'] as $key => $field_label):
                  $val = $group_data[$key] ?? '';
                  if (!$val) continue;
                ?>
                  <div class="property-specs__list--item">
                    <p><?php echo esc_html($field_label); ?></p>
                    <p><?php echo esc_html($val); ?></p>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ===== TESTIMONIALS REUSABLE BLOCK ===== -->
  <?php if ($testimonials_id): ?>
    <?php get_template_part('template-parts/blocks/reusable-block', null, [
      'reusable-block-post' => $testimonials_id,
    ]); ?>
  <?php endif; ?>

  <!-- ===== CARDS GRID ===== -->
  <?php
  $cards_grid = get_field('property-cards-grid');
  if (!empty($cards_grid['cards-grid-posts'])):
    get_template_part('template-parts/blocks/cards-grid', null, $cards_grid);
  endif;
  ?>

  <!-- ===== CTA REUSABLE BLOCK ===== -->
  <?php if ($cta_id): ?>
    <?php get_template_part('template-parts/blocks/reusable-block', null, [
      'reusable-block-post' => $cta_id,
    ]); ?>
  <?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>