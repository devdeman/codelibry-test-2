<?php

$buttons = get_array_value($args, 'buttons');

$button_style_map = [
  'orange' => "",
  'black' => "button--secondary",
  'white-outline' => "button--white-outline",
  'orange-outline' => "button--orange-outline",
  'white' => "button--white",
  'text-arrow' => "button--text-arrow",
];

if (empty($buttons)) {
  return;
}

?>

<?php if (!empty($buttons) && is_array($buttons)): ?>
  <div class="buttons">
    <?php foreach ($buttons as $button): ?>
      <?php
      $button_link = $button['link']['url'];
      $button_title = $button['link']['title'];
      $button_target = $button['link']['target'] ? $button['link']['target'] : '_self';
      $button_style = get_array_value($button, 'style', 'blue');
      $button_class = get_array_value($button_style_map, $button_style);
      ?>
      <a class="button <?php echo esc_attr($button_class); ?>"
        href="<?php echo esc_attr($button_link); ?>" target="<?php echo esc_attr($button_target); ?>"
        data-text="<?php echo esc_attr($button_title); ?>">
        <span><?php echo esc_html($button_title); ?></span>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>