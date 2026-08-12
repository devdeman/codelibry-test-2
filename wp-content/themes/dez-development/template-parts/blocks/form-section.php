<?php

$text          = get_array_value($args, 'form-section-text', get('form-section-text'));
$buttons       = get_array_value($args, 'form-section-buttons', get('form-section-buttons'));
$show_contacts = get_array_value($args, 'form-section-show-contacts', get('form-section-show-contacts'));
$address       = get_array_value($args, 'form-section-address', get('form-section-address'));
$phone         = get_array_value($args, 'form-section-phone', get('form-section-phone'));
$email         = get_array_value($args, 'form-section-email', get('form-section-email'));
$hours         = get_array_value($args, 'form-section-hours', get('form-section-hours'));
$form_id       = get_array_value($args, 'form-section-form', get('form-section-form'));

if (!$text && !$form_id) {
  return;
}

$form_title = '';
if ($form_id && function_exists('wpcf7_contact_form')) {
  $cf7 = wpcf7_contact_form((int) $form_id);
  if ($cf7) {
    $form_title = $cf7->title();
  }
}

$render_svg = function (string $url): void {
  if (!$url || !str_ends_with($url, '.svg')) return;
  $uploads = wp_get_upload_dir();
  $path    = str_replace($uploads['baseurl'], $uploads['basedir'], $url);
  if (file_exists($path)) echo file_get_contents($path);
};

?>

<section class="form-section | section">
  <div class="container-lg">
    <div class="form-section__inner">

      <div class="form-section__box">
        <?php if ($text): ?>
          <div class="form-section__content">
            <?php echo wp_kses_post($text); ?>
          </div>
        <?php endif; ?>

        <?php if ($show_contacts): ?>
          <div class="form-section__contacts">

            <?php if (!empty($address['link']['title']) || !empty($address['link']['url'])): ?>
              <div class="form-section__contact">
                <span class="form-section__contact-icon">
                  <?php $render_svg($address['icon'] ?? ''); ?>
                </span>
                <?php if (!empty($address['link']['url'])): ?>
                  <a href="<?php echo esc_url($address['link']['url']); ?>" target="_blank" rel="noopener">
                    <?php echo esc_html($address['link']['title'] ?: $address['link']['url']); ?>
                  </a>
                <?php else: ?>
                  <span><?php echo esc_html($address['link']['title']); ?></span>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($phone['link'])): ?>
              <div class="form-section__contact">
                <span class="form-section__contact-icon">
                  <?php $render_svg($phone['icon'] ?? ''); ?>
                </span>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^\d+]/', '', $phone['link'])); ?>">
                  <?php echo esc_html($phone['link']); ?>
                </a>
              </div>
            <?php endif; ?>

            <?php if (!empty($email['link'])): ?>
              <div class="form-section__contact">
                <span class="form-section__contact-icon">
                  <?php $render_svg($email['icon'] ?? ''); ?>
                </span>
                <a href="mailto:<?php echo esc_attr($email['link']); ?>">
                  <?php echo esc_html($email['link']); ?>
                </a>
              </div>
            <?php endif; ?>

            <?php if (!empty($hours['link'])): ?>
              <div class="form-section__contact">
                <span class="form-section__contact-icon">
                  <?php $render_svg($hours['icon'] ?? ''); ?>
                </span>
                <span><?php echo esc_html($hours['link']); ?></span>
              </div>
            <?php endif; ?>

          </div>
        <?php endif; ?>

        <?php get_template_part('template-parts/blocks/parts/buttons', null, [
          'buttons' => $buttons,
        ]); ?>
      </div>

      <div class="form-section__card">
        <?php if ($form_title): ?>
          <div class="form-section__label"><?php echo esc_html($form_title); ?></div>
        <?php endif; ?>
        <?php if ($form_id): ?>
          <?php echo do_shortcode('[contact-form-7 id="' . absint($form_id) . '"]'); ?>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>