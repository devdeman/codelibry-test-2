<?php

$text         = get_array_value($args, 'managers-text', get('managers-text'));
$buttons      = get_array_value($args, 'managers-buttons', get('managers-buttons'));
$manager_type = get_array_value($args, 'manager-type', get('manager-type'));
$manager      = $manager_type ? get($manager_type, $options = true) : null;

if (!$buttons && !$text && !$manager) {
  return;
}

?>

<section class="managers | section">
  <div class="container-lg">
    <div class="managers__inner">

      <div class="managers__box">
        <?php if ($text): ?>
          <div class="managers__content">
            <?php echo wp_kses_post($text); ?>
          </div>
        <?php endif; ?>

        <?php get_template_part('template-parts/blocks/parts/buttons', null, [
          'buttons' => $buttons,
        ]); ?>
      </div>

      <?php get_template_part('template-parts/blocks/parts/managers', null, [
        'manager' => $manager,
      ]); ?>

    </div>
  </div>
</section>
