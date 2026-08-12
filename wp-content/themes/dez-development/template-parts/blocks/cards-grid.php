<?php

$label   = get_array_value($args, 'cards-grid-label',   get('cards-grid-label'));
$title   = get_array_value($args, 'cards-grid-title',   get('cards-grid-title'));
$link    = get_array_value($args, 'cards-grid-link',    get('cards-grid-link'));
$columns = get_array_value($args, 'cards-grid-columns', get('cards-grid-columns')) ?: '3';
$posts   = get_array_value($args, 'cards-grid-posts',   get('cards-grid-posts'));

if (empty($posts)) return;

$link_url    = $link['url']    ?? '';
$link_title  = $link['title']  ?? '';
$link_target = $link['target'] ?? '_self';

?>

<section class="cards-grid | section">
  <div class="container-lg">

    <?php if ($label || $title || $link_url): ?>
      <div class="cards-grid__header">

        <?php if ($label): ?>
          <p class="cards-grid__label"><?php echo esc_html($label); ?></p>
        <?php endif; ?>
        <div>
          <?php if ($title): ?>
            <h2 class="cards-grid__title"><?php echo esc_html($title); ?></h2>
          <?php endif; ?>

          <?php if ($link_url): ?>
            <a href="<?php echo esc_url($link_url); ?>" class="button button--text-arrow" target="<?php echo esc_attr($link_target); ?>">
              <?php echo esc_html($link_title); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="cards-grid__grid cards-grid__grid--<?php echo esc_attr($columns); ?>">
      <?php foreach ((array) $posts as $post_id):
        $post_type = get_post_type($post_id);
        if ($post_type === 'communities') {
          get_template_part('template-parts/parts/community-card', null, ['post_id' => $post_id]);
        } else {
          get_template_part('template-parts/parts/property-card', null, ['post_id' => $post_id]);
        }
      endforeach; ?>
    </div>

  </div>
</section>
