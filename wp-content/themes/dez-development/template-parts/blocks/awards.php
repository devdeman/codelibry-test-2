<?php

$label    = get_array_value($args, 'awards-label', get('awards-label'));
$title    = get_array_value($args, 'awards-title', get('awards-title'));
$post_ids = get_array_value($args, 'awards-posts', get('awards-posts'));

if (empty($post_ids)) {
    return;
}

$awards = get_posts([
    'post_type'      => 'award',
    'posts_per_page' => -1,
    'post__in'       => (array) $post_ids,
    'orderby'        => 'post__in',
    'post_status'    => 'publish',
]);

if (empty($awards)) {
    return;
}

?>

<section class="awards-block | section">
  <div class="container-lg">

    <?php if ($label || $title): ?>
      <div class="awards-block__header">
        <?php if ($label): ?>
          <p class="awards-block__label"><?php echo esc_html($label); ?></p>
        <?php endif; ?>
        <?php if ($title): ?>
          <h2 class="awards-block__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="awards-block__grid">
      <?php foreach ($awards as $award):
        $thumb_id   = get_post_thumbnail_id($award->ID);
        $award_title = get_the_title($award->ID);
        $description = get_field('description', $award->ID);
      ?>
        <div class="awards-block__card">
          <?php if ($thumb_id): ?>
            <div class="awards-block__image">
              <?php echo wp_get_attachment_image($thumb_id, 'large', false, ['loading' => 'lazy']); ?>
            </div>
          <?php endif; ?>
          <h3 class="awards-block__name"><?php echo esc_html($award_title); ?></h3>
          <?php if ($description): ?>
            <p class="awards-block__description"><?php echo esc_html($description); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
