<?php

$sections      = get_array_value($args, 'content-doc-sections', get('content-doc-sections'));
$updated_raw   = get_array_value($args, 'content-doc-updated', get('content-doc-updated'));
$show_reviewed = get_array_value($args, 'content-doc-show-reviewed', get('content-doc-show-reviewed'));
$pdf           = get_array_value($args, 'content-doc-pdf', get('content-doc-pdf'));

if (empty($sections)) return;

$updated         = $updated_raw ? date_i18n('M Y', strtotime($updated_raw)) : '';
$has_any_label   = !empty(array_filter(array_column($sections, 'section-label')));

?>

<section class="content-doc section">
  <div class="container-lg">
    <div class="content-doc__inner">
      <div>
        <!-- Content body -->
        <div class="content-doc__body">
          <?php foreach ($sections as $index => $section):
            $title         = $section['section-title']     ?? '';
            $title_tag     = $section['section-title-tag'] ?? 'h2';
            $title_tag     = in_array($title_tag, ['h2', 'h3', 'h4'], true) ? $title_tag : 'h2';
            $content       = $section['section-content']   ?? '';
            $section_label = $section['section-label']     ?? '';
            $anchor        = 'doc-' . sanitize_title($title);
          ?>
            <div class="content-doc__section"
              id="<?php echo esc_attr($anchor); ?>"
              data-section-label="<?php echo esc_attr($section_label); ?>">
              <?php if ($title): ?>
                <<?php echo $title_tag; ?> class="content-doc__section-title"><?php echo esc_html($title); ?></<?php echo $title_tag; ?>>
              <?php endif; ?>
              <?php if ($content): ?>
                <div class="content-doc__section-content">
                  <?php echo wp_kses_post($content); ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <?php if ($show_reviewed && $updated): ?>
          <p class="content-doc__reviewed">Last reviewed: <?php echo esc_html(date_i18n('F Y', strtotime($updated_raw))); ?></p>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <aside class="content-doc__sidebar">
        <div class="content-doc__nav-box">

          <p class="content-doc__label">ON THIS PAGE</p>

          <nav class="content-doc__nav" aria-label="Page sections">
            <ul>
              <?php foreach ($sections as $index => $section):
                $title  = $section['section-title'] ?? '';
                if (!$title) continue;
                $anchor = 'doc-' . sanitize_title($title);
              ?>
                <li>
                  <a href="#<?php echo esc_attr($anchor); ?>">
                    <?php echo esc_html($title); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </nav>

          <?php if ($has_any_label || $updated): ?>
            <div class="content-doc__meta">
              <?php if ($has_any_label): ?>
                <div class="content-doc__meta-row content-doc__meta-section" hidden>
                  <span class="content-doc__meta-key">Section</span>
                  <span class="content-doc__meta-value content-doc__meta-section-value"></span>
                </div>
              <?php endif; ?>
              <?php if ($updated): ?>
                <div class="content-doc__meta-row">
                  <span class="content-doc__meta-key">Updated</span>
                  <span class="content-doc__meta-value"><?php echo esc_html($updated); ?></span>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($pdf['url'])): ?>
            <?php $pdf_label = $pdf['title'] ?: 'Download PDF'; ?>
            <?php
            $pdf_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" d="m12 16-5-5 1.4-1.45 2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.824 0-1.412-.587A1.93 1.93 0 0 1 4 18v-3h2v3h12v-3h2v3q0 .824-.587 1.413A1.93 1.93 0 0 1 18 20z"/></svg>';
            ?>
            <a href="<?php echo esc_url($pdf['url']); ?>"
              class="button button--secondary content-doc__pdf"
              <?php if (!empty($pdf['target'])): ?>target="<?php echo esc_attr($pdf['target']); ?>" <?php endif; ?>>
              <span><?php echo $pdf_svg;
                    echo esc_html($pdf_label); ?></span>
              <span class="content-doc__pdf-clone" aria-hidden="true"><?php echo $pdf_svg;
                                                                      echo esc_html($pdf_label); ?></span>
            </a>
          <?php endif; ?>

        </div>
      </aside>

    </div>
  </div>
</section>