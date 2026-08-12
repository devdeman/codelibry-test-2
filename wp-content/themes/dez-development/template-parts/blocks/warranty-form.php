<?php

$label   = get_array_value($args, 'warranty-form-label', get('warranty-form-label'));
$title   = get_array_value($args, 'warranty-form-title', get('warranty-form-title'));
$form_id = get_array_value($args, 'warranty-form-form', get('warranty-form-form'));

if (!$form_id) {
  return;
}

?>

<section class="warranty-form | section">
  <div class="container-lg">

    <?php if ($label || $title): ?>
      <div class="warranty-form__header">
        <?php if ($label): ?>
          <p class="warranty-form__label"><?php echo esc_html($label); ?></p>
        <?php endif; ?>
        <?php if ($title): ?>
          <h2 class="warranty-form__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="warranty-form__body">
      <?php echo do_shortcode('[contact-form-7 id="' . absint($form_id) . '"]'); ?>
    </div>

  </div>
</section>