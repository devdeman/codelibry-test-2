<?php

$stats = get_array_value($args, 'numbers-stats', get('numbers-stats'));

if (!$stats) {
  return;
}

?>

<section class="numbers | section">
  <div class="container-lg">
    <div class="numbers__inner grid" data-columns="3">

      <?php if (!empty($stats) && is_array($stats)): ?>
        <?php foreach ($stats as $stat): ?>
          <?php
          $title = get_array_value($stat, 'title') ?: '';
          $text = get_array_value($stat, 'text') ?: '';
          ?>
          <div class="numbers__item">
            <?php if ($title): ?>
              <?php echo $title; ?>
            <?php endif; ?>

            <?php if ($text): ?>
              <p class="numbers__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>
  </div>
</section>