<?php

$label    = get_array_value($args, 'team-label', get('team-label'));
$title    = get_array_value($args, 'team-title', get('team-title'));
$post_ids = get_array_value($args, 'team-posts', get('team-posts'));

if (empty($post_ids)) {
  return;
}

$members = get_posts([
  'post_type'      => 'team-member',
  'posts_per_page' => -1,
  'post__in'       => (array) $post_ids,
  'orderby'        => 'post__in',
  'post_status'    => 'publish',
]);

if (empty($members)) {
  return;
}

?>

<section class="team-block | section" id="team">
  <div class="container-lg">

    <?php if ($label || $title): ?>
      <div class="team-block__header">
        <?php if ($label): ?>
          <p class="team-block__label"><?php echo esc_html($label); ?></p>
        <?php endif; ?>
        <?php if ($title): ?>
          <h2 class="team-block__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="team-block__grid">
      <?php foreach ($members as $member):
        $photo_id     = get_post_thumbnail_id($member->ID);
        $position     = get_field('position', $member->ID);
        $contact_link = get_field('contact-link', $member->ID);
      ?>
        <div class="team-block__card">
          <div class="team-block__image">
            <?php if ($photo_id): ?>
              <?php echo wp_get_attachment_image($photo_id, 'large', false, ['loading' => 'lazy']); ?>
            <?php else: ?>
              <div class="team-block__image-placeholder"></div>
            <?php endif; ?>
          </div>
          <div class="team-block__body">
            <h3 class="team-block__name"><?php echo esc_html(get_the_title($member->ID)); ?></h3>
            <?php if ($position): ?>
              <p class="team-block__position"><?php echo esc_html($position); ?></p>
            <?php endif; ?>
            <?php if ($contact_link): ?>
              <div class="team-block__footer">
                <a href="<?php echo esc_url($contact_link['url']); ?>"
                  class="button button--text-arrow"
                  <?php echo $contact_link['target'] ? 'target="' . esc_attr($contact_link['target']) . '"' : ''; ?>>
                  <?php echo esc_html($contact_link['title'] ?: __('Contact', 'codelibry')); ?>
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>