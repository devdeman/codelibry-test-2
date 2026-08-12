<?php

$label = get_array_value($args, 'process-cards-label', get('process-cards-label'));
$title = get_array_value($args, 'process-cards-title', get('process-cards-title'));
$cards_list = get_array_value($args, 'process-cards-list', get('process-cards-list'));

if (!$cards_list) {
  return;
}
$columns = is_array($cards_list) ? count($cards_list) : 3;
?>

<section class="process-cards | section">
  <div class="container-lg">
    <div class="process-cards__inner">

      <?php if ($label): ?>
        <p class="process-cards__label"><?php echo esc_html($label); ?></p>
      <?php endif; ?>

      <?php if ($title): ?>
        <h2 class="process-cards__title"><?php echo esc_html($title); ?></h2>
      <?php endif; ?>

      <div class="grid" data-columns="<?php echo esc_attr($columns); ?>">
        <?php if (!empty($cards_list) && is_array($cards_list)): ?>
          <?php foreach ($cards_list as $i => $card): ?>
            <?php
            $title = get_array_value($card, 'title') ?: '';
            $text = get_array_value($card, 'text') ?: '';
            $image = get_array_value($card, 'image') ?: '';
            $numbered_headings = get_array_value($card, 'numbered-headings') ?: boolval(false);
            ?>
            <div class="process-cards__item">
              <div>
                <?php if ($image): ?>
                  <figure class="process-cards__image">
                    <?php echo wp_get_attachment_image($image, 'full', false, [
                      'loading' => 'lazy',
                    ]); ?>
                  </figure>
                <?php endif; ?>
                <?php if ($title): ?>
                  <div class="process-cards__heading">
                    <?php if ($numbered_headings): ?>
                      <span><?php echo sprintf('%02d', $i + 1); ?></span>
                    <?php endif; ?>
                    <h3><?php echo esc_html($title); ?></h3>
                  </div>
                <?php endif; ?>
              </div>

              <?php if ($text): ?>
                <p class="process-cards__text"><?php echo esc_html($text); ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>