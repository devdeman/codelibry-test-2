<?php

$cta1 = get('cta-button-1', true);
$cta2 = get('cta-button-2', true);


if ($cta1 || !empty($cta1['url'])) : ?>

<a class="header__cta-button | button button--secondary"
    href="<?php echo esc_url($cta1['url']); ?>"
    data-text="<?php echo esc_attr($cta1['title']); ?>"
    <?php if (!empty($cta1['target'])) echo 'target="' . esc_attr($cta1['target']) . '"'; ?>>
    <span><?php echo esc_html($cta1['title']); ?></span>
</a>

<?php endif; ?>


<?php if ($cta2 || !empty($cta2['url'])) : ?>


<a class="header__cta-button | button"
    href="<?php echo esc_url($cta2['url']); ?>"
    data-text="<?php echo esc_attr($cta2['title']); ?>"
    <?php if (!empty($cta2['target'])) echo 'target="' . esc_attr($cta2['target']) . '"'; ?>>
    <span><?php echo esc_html($cta2['title']); ?></span>
</a>

<?php endif; ?>