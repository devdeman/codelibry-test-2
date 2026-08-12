<?php

$text = get_array_value($args, 'image-text-text', get('image-text-text'));
$stats = get_array_value($args, 'image-text-stats', get('image-text-stats'));
$buttons = get_array_value($args, 'image-text-buttons', get('image-text-buttons'));
$image = get_array_value($args, 'image-text-image', get('image-text-image'));

if (!$image && !$text) {
    return;
}

?>

<section class="image-text | section">
    <div class="container-lg">
        <div class="image-text__inner">
            <?php if ($image): ?>
                <figure class="image-text__media">
                    <?php echo wp_get_attachment_image($image, 'large', false, ['class' => 'image-text__img', 'loading' => 'lazy']); ?>
                </figure>
            <?php endif; ?>
            <div class="image-text__box">
                <?php if ($text): ?>
                    <div class="image-text__content">
                        <?php echo wp_kses_post($text); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($stats) && is_array($stats)): ?>
                    <div class="image-text__stats">
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
                    </div>
                <?php endif; ?>

                <?php get_template_part('template-parts/blocks/parts/buttons', null, [
                    'buttons' => $buttons,
                ]); ?>
            </div>
        </div>
    </div>
</section>