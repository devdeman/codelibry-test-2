<?php

$manager = get_array_value($args, 'manager');

if (!$manager) return;

$render_svg = function (string $url): void {
  if (!$url || !str_ends_with($url, '.svg')) return;
  $uploads = wp_get_upload_dir();
  $path    = str_replace($uploads['baseurl'], $uploads['basedir'], $url);
  if (file_exists($path)) echo file_get_contents($path);
};

?>

<div class="managers__manager">

  <?php if (!empty($manager['type-label'])): ?>
    <div class="managers__manager-label">
      <?php echo esc_html($manager['type-label']); ?>
    </div>
  <?php endif; ?>

  <div class="managers__manager-profile">
    <?php if (!empty($manager['image'])): ?>
      <div class="managers__manager-photo">
        <?php echo wp_get_attachment_image($manager['image'], 'thumbnail'); ?>
      </div>
    <?php endif; ?>
    <div class="managers__manager-info">
      <?php if (!empty($manager['name'])): ?>
        <div class="managers__manager-name"><?php echo esc_html($manager['name']); ?></div>
      <?php endif; ?>
      <?php if (!empty($manager['position'])): ?>
        <div class="managers__manager-position"><?php echo esc_html($manager['position']); ?></div>
      <?php endif; ?>
    </div>
  </div>

  <div class="managers__manager-contacts">
    <?php if (!empty($manager['phone']['link'])): ?>
      <div class="managers__manager-contact">
        <span class="managers__manager-contact-icon">
          <?php $render_svg($manager['phone']['icon'] ?? ''); ?>
        </span>
        <a href="tel:<?php echo esc_attr(preg_replace('/[^\d+]/', '', $manager['phone']['link'])); ?>">
          <?php echo esc_html($manager['phone']['link']); ?>
        </a>
      </div>
    <?php endif; ?>

    <?php if (!empty($manager['email']['link'])): ?>
      <div class="managers__manager-contact">
        <span class="managers__manager-contact-icon">
          <?php $render_svg($manager['email']['icon'] ?? ''); ?>
        </span>
        <a href="mailto:<?php echo esc_attr($manager['email']['link']); ?>">
          <?php echo esc_html($manager['email']['link']); ?>
        </a>
      </div>
    <?php endif; ?>

    <?php if (!empty($manager['schedule']['link'])): ?>
      <div class="managers__manager-contact">
        <span class="managers__manager-contact-icon">
          <?php $render_svg($manager['schedule']['icon'] ?? ''); ?>
        </span>
        <span><?php echo esc_html($manager['schedule']['link']); ?></span>
      </div>
    <?php endif; ?>
  </div>

  <?php if (!empty($manager['send-message']['url'])):
    get_template_part('template-parts/blocks/parts/buttons', null, [
      'buttons' => [[
        'link'  => $manager['send-message'],
        'style' => 'black',
      ]],
    ]);
  endif; ?>

</div>
