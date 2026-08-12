<?php

add_filter('manage_communities_posts_columns', function ($columns) {
    $columns['homes_count'] = __('Homes', 'codelibry');
    return $columns;
});

add_action('manage_communities_posts_custom_column', function ($column, $post_id) {
    if ($column === 'homes_count') {
        $count = (int) get_post_meta($post_id, '_community_homes_count', true);
        echo $count ? esc_html($count) : '—';
    }
}, 10, 2);

add_action('edit_form_after_title', function ($post) {
    if ($post->post_type !== 'communities') return;

    $count = (int) get_post_meta($post->ID, '_community_homes_count', true);
    if (!$count) return;
    ?>
    <p style="margin-top: 8px; color: #787c82;">
        <?php echo esc_html(sprintf(
            __('Available Homes: %d', 'codelibry'),
            $count
        )); ?>
    </p>
    <?php
});
