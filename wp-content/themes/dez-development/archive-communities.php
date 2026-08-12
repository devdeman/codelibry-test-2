<?php

get_header();

global $wp_query;

add_action('pre_get_posts', function (WP_Query $query): void {
    if (
        is_admin()
        || ! $query->is_main_query()
        || ! $query->is_post_type_archive('communities')
    ) {
        return;
    }

    $query->set('posts_per_page', -1);
    $query->set('post_status', 'publish');
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
});

$hero_image = get('hero-image', true);
$hero_label = get('hero-label', true);
$hero_title = get('hero-title', true);
$hero_text  = get('hero-text', true);

$total = (int) $wp_query->found_posts;

$area_terms = get_terms([
    'taxonomy'   => 'community-area',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

$city_terms = get_terms([
    'taxonomy'   => 'community-city',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

$school_terms = get_terms([
    'taxonomy'   => 'community-schools',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

/**
 * Archive filter dropdown.
 *
 * @param string              $param
 * @param string              $label
 * @param array<WP_Term>|array $items
 * @param bool                $active
 */
$render_filter = static function (
    string $param,
    string $label,
    array $items,
    bool $active = false
): void {
    ?>
    <div
        class="filter-select js-filter-select"
        data-param="<?php echo esc_attr($param); ?>"
        data-value=""
        data-placeholder="<?php echo esc_attr($label); ?>"
    >
        <button
            class="filter-select__trigger"
            type="button"
            aria-haspopup="listbox"
            aria-expanded="false"
        >
            <span class="filter-select__label">
                <?php echo esc_html($label); ?>
            </span>

            <svg
                class="filter-select__chevron"
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
                aria-hidden="true"
            >
                <path
                    d="M4.5 6.75L9 11.25L13.5 6.75"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </button>

        <div class="filter-select__dropdown">
            <div class="filter-select__list" role="listbox">
                <button
                    class="filter-select__item is-active"
                    type="button"
                    data-value=""
                    role="option"
                    aria-selected="true"
                >
                    <?php
                    printf(
                        esc_html__('All %s', 'codelibry'),
                        esc_html($label)
                    );
                    ?>
                </button>

                <?php foreach ($items as $item): ?>
                    <button
                        class="filter-select__item"
                        type="button"
                        data-value="<?php echo esc_attr($item->slug); ?>"
                        role="option"
                        aria-selected="false"
                    >
                        <?php echo esc_html($item->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
};

?>

<?php if ($hero_image || $hero_label || $hero_title || $hero_text): ?>
    <section class="community-archive-hero">
        <?php if ($hero_image): ?>
            <div class="community-archive-hero__image">
                <?php
                echo wp_get_attachment_image(
                    $hero_image,
                    'full',
                    false,
                    [
                        'loading'       => false,
                        'decoding'      => 'sync',
                        'fetchpriority' => 'high',
                    ]
                );
                ?>
            </div>
        <?php endif; ?>

        <div class="container-lg">
            <div class="community-archive-hero__content">
                <?php if ($hero_label): ?>
                    <p class="community-archive-hero__label">
                        <?php echo esc_html($hero_label); ?>
                    </p>
                <?php endif; ?>

                <?php if ($hero_title): ?>
                    <h1 class="community-archive-hero__title">
                        <?php echo esc_html($hero_title); ?>
                    </h1>
                <?php endif; ?>

                <?php if ($hero_text): ?>
                    <p class="community-archive-hero__text">
                        <?php echo esc_html($hero_text); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section
    class="community-view js-archive-view"
    data-view="map"
    id="community-results"
>
    <div class="community-view__filters">
        <div class="container-lg">
            <div class="community-view__filters-inner">

                <div class="community-view__filters-main">
                    <?php
                    $render_filter(
                        'area',
                        __('Area', 'codelibry'),
                        is_wp_error($area_terms) ? [] : $area_terms,
                        true
                    );

                    $render_filter(
                        'city',
                        __('City', 'codelibry'),
                        is_wp_error($city_terms) ? [] : $city_terms
                    );

                    $render_filter(
                        'schools',
                        __('Schools', 'codelibry'),
                        is_wp_error($school_terms) ? [] : $school_terms
                    );
                    ?>
                </div>

                <div
                    class="filter-select filter-select--sort js-filter-select"
                    data-param="orderby"
                    data-value="title_asc"
                    data-placeholder="<?php esc_attr_e('Name A–Z', 'codelibry'); ?>"
                    data-prefix="<?php esc_attr_e('Sort: ', 'codelibry'); ?>"
                >
                    <button
                        class="filter-select__trigger"
                        type="button"
                        aria-haspopup="listbox"
                        aria-expanded="false"
                    >
                        <span class="filter-select__label">
                            <?php esc_html_e('Sort: Name A–Z', 'codelibry'); ?>
                        </span>

                        <svg
                            class="filter-select__chevron"
                            width="18"
                            height="18"
                            viewBox="0 0 18 18"
                            fill="none"
                            aria-hidden="true"
                        >
                            <path
                                d="M4.5 6.75L9 11.25L13.5 6.75"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </button>

                    <div class="filter-select__dropdown">
                        <div class="filter-select__list" role="listbox">
                            <button
                                class="filter-select__item is-active"
                                type="button"
                                data-value="title_asc"
                                role="option"
                                aria-selected="true"
                            >
                                <?php esc_html_e('Name A–Z', 'codelibry'); ?>
                            </button>

                            <button
                                class="filter-select__item"
                                type="button"
                                data-value="title_desc"
                                role="option"
                                aria-selected="false"
                            >
                                <?php esc_html_e('Name Z–A', 'codelibry'); ?>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="community-view__content">
        <div class="container-lg-wrap">
            <div class="community-view__layout">

                <div class="community-view__map-column">
                        <div class="community-view__map-container">
                            <div class="community-view__bar-wrap bar-desktop">
                            <div class="community-view__bar">
                                <p
                                    class="community-view__count"
                                    aria-live="polite"
                                >
                                    <?php
                                    printf(
                                        esc_html(
                                            _n(
                                                '%d Community Found',
                                                '%d Communities Found',
                                                $total,
                                                'codelibry'
                                            )
                                        ),
                                        $total
                                    );
                                    ?>
                                </p>

                                <button
                                    class="community-view__toggle js-view-toggle"
                                    type="button"
                                    aria-label="<?php esc_attr_e('Toggle archive view', 'codelibry'); ?>"
                                >
                                    <span class="community-view__icon community-view__icon--list">
                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 20 20"
                                            fill="none"
                                            aria-hidden="true"
                                        >
                                            <path
                                                d="M7.5 5H17M7.5 10H17M7.5 15H17"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <path
                                                d="M3 5H4M3 10H4M3 15H4"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                            />
                                        </svg>
                                    </span>

                                    <span class="community-view__icon community-view__icon--map">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="mask0_343_3596" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                                            <rect width="24" height="24" fill="#D9D9D9"/>
                                            </mask>
                                            <g mask="url(#mask0_343_3596)">
                                            <path d="M13.4125 11.4125C13.8042 11.0208 14 10.55 14 10C14 9.45 13.8042 8.97917 13.4125 8.5875C13.0208 8.19583 12.55 8 12 8C11.45 8 10.9792 8.19583 10.5875 8.5875C10.1958 8.97917 10 9.45 10 10C10 10.55 10.1958 11.0208 10.5875 11.4125C10.9792 11.8042 11.45 12 12 12C12.55 12 13.0208 11.8042 13.4125 11.4125ZM12 19.35C14.0333 17.4833 15.5417 15.7875 16.525 14.2625C17.5083 12.7375 18 11.3833 18 10.2C18 8.38333 17.4208 6.89583 16.2625 5.7375C15.1042 4.57917 13.6833 4 12 4C10.3167 4 8.89583 4.57917 7.7375 5.7375C6.57917 6.89583 6 8.38333 6 10.2C6 11.3833 6.49167 12.7375 7.475 14.2625C8.45833 15.7875 9.96667 17.4833 12 19.35ZM12 22C9.31667 19.7167 7.3125 17.5958 5.9875 15.6375C4.6625 13.6792 4 11.8667 4 10.2C4 7.7 4.80417 5.70833 6.4125 4.225C8.02083 2.74167 9.88333 2 12 2C14.1167 2 15.9792 2.74167 17.5875 4.225C19.1958 5.70833 20 7.7 20 10.2C20 11.8667 19.3375 13.6792 18.0125 15.6375C16.6875 17.5958 14.6833 19.7167 12 22Z" fill="#2B2B2B"/>
                                            </g>
                                        </svg>

                                    </span>

                                    <span class="community-view__label community-view__label--list">
                                        <?php esc_html_e('List', 'codelibry'); ?>
                                    </span>

                                    <span class="community-view__label community-view__label--map">
                                        <?php esc_html_e('Map', 'codelibry'); ?>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div
                            id="community-map"
                            class="community-view__map"
                            aria-label="<?php esc_attr_e('Communities map', 'codelibry'); ?>"
                        ></div>
                    </div>
                </div>

                <div class="community-view__results">
                    <div class="community-view__bar-wrap bar-mobile">
                        <div class="community-view__bar">
                            <p
                                class="community-view__count"
                                aria-live="polite"
                            >
                                <?php
                                printf(
                                    esc_html(
                                        _n(
                                            '%d Community Found',
                                            '%d Communities Found',
                                            $total,
                                            'codelibry'
                                        )
                                    ),
                                    $total
                                );
                                ?>
                            </p>

                            <button
                                class="community-view__toggle js-view-toggle"
                                type="button"
                                aria-label="<?php esc_attr_e('Toggle archive view', 'codelibry'); ?>"
                            >
                                <span class="community-view__icon community-view__icon--list">
                                    <svg
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M7.5 5H17M7.5 10H17M7.5 15H17"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                        />
                                        <path
                                            d="M3 5H4M3 10H4M3 15H4"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                        />
                                    </svg>
                                </span>

                                <span class="community-view__icon community-view__icon--map">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_343_3596" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                                        <rect width="24" height="24" fill="#D9D9D9"/>
                                        </mask>
                                        <g mask="url(#mask0_343_3596)">
                                        <path d="M13.4125 11.4125C13.8042 11.0208 14 10.55 14 10C14 9.45 13.8042 8.97917 13.4125 8.5875C13.0208 8.19583 12.55 8 12 8C11.45 8 10.9792 8.19583 10.5875 8.5875C10.1958 8.97917 10 9.45 10 10C10 10.55 10.1958 11.0208 10.5875 11.4125C10.9792 11.8042 11.45 12 12 12C12.55 12 13.0208 11.8042 13.4125 11.4125ZM12 19.35C14.0333 17.4833 15.5417 15.7875 16.525 14.2625C17.5083 12.7375 18 11.3833 18 10.2C18 8.38333 17.4208 6.89583 16.2625 5.7375C15.1042 4.57917 13.6833 4 12 4C10.3167 4 8.89583 4.57917 7.7375 5.7375C6.57917 6.89583 6 8.38333 6 10.2C6 11.3833 6.49167 12.7375 7.475 14.2625C8.45833 15.7875 9.96667 17.4833 12 19.35ZM12 22C9.31667 19.7167 7.3125 17.5958 5.9875 15.6375C4.6625 13.6792 4 11.8667 4 10.2C4 7.7 4.80417 5.70833 6.4125 4.225C8.02083 2.74167 9.88333 2 12 2C14.1167 2 15.9792 2.74167 17.5875 4.225C19.1958 5.70833 20 7.7 20 10.2C20 11.8667 19.3375 13.6792 18.0125 15.6375C16.6875 17.5958 14.6833 19.7167 12 22Z" fill="#2B2B2B"/>
                                        </g>
                                    </svg>

                                </span>

                                <span class="community-view__label community-view__label--list">
                                    <?php esc_html_e('List', 'codelibry'); ?>
                                </span>

                                <span class="community-view__label community-view__label--map">
                                    <?php esc_html_e('Map', 'codelibry'); ?>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="community-view__cards">
                        <?php if (have_posts()): ?>
                            <?php while (have_posts()): ?>
                                <?php the_post(); ?>

                                <?php
                                get_template_part(
                                    'template-parts/parts/community-card',
                                    null,
                                    [
                                        'show_location_btn' => true,
                                        'post_id'           => get_the_ID(),
                                    ]
                                );
                                ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="community-view__no-results">
                                <?php esc_html_e('No communities found.', 'codelibry'); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>