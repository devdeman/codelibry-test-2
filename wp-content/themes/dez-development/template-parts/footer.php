<?php

// ACF Options
$footer_description = get('footer-description', $options = true);
$footer_company_name = get('footer-company-name', $options = true);
$footer_contact = get('contacts', $options = true);

// get all menu locations
$locations = get_nav_menu_locations();

// filter to get only footer menus
$locations = array_filter($locations, fn($location) => str_contains($location, 'footer-menu'), ARRAY_FILTER_USE_KEY);
$locations = array_filter($locations, fn($location) => $location !== 0);

// create array menus to render in html
$menus = array_map(function ($menu_id, $location) {
  $menu = wp_get_nav_menu_object($menu_id);

  return [
    'title' => $menu->name ?? 'Menu Title',
    'menu' => wp_nav_menu([
      'theme_location' => $location,
      'echo' => false,
    ])
  ];
}, $locations, array_keys($locations), array_values($locations));

?>

<footer class="footer" id="footer">
  <div class="container-lg">
    <div class="footer__inner | flow">
      <div class="footer__main | repel">
        <div class="footer__info | flow">
          <a href="<?php echo home_url() ?>" class="footer__logo">
            <?php echo get_inline_svg('logo-footer') ?>
            <span class="visually-hidden"><?php esc_html_e('Go to homepage', 'codelibry') ?></span>
          </a>

          <?php if ($footer_description): ?>
            <div class="footer__description | flow">
              <?php echo wpautop($footer_description) ?>
            </div>
          <?php endif; ?>
        </div>

        <div class="footer__menu-wrapper | cluster">
          <?php foreach ($menus as $menu): ?>
            <div class="footer__column | flow">
              <h4 class="h5">
                <?php echo $menu['title'] ?>
              </h4>
              <?php echo $menu['menu'] ?>
            </div>
          <?php endforeach; ?>

          <div class="footer__column | flow">
            <h4 class="h5">Contacts</h4>
            <ul class="footer__contacts">
              <?php if (!empty($footer_contact) && is_array($footer_contact)): ?>
                <?php foreach ($footer_contact as $contact): ?>
                  <?php
                  $icon = get_array_value($contact, 'icon');
                  $link = get_array_value($contact, 'link');
                  $link_url = get_array_value($link, 'url');
                  $link_title = get_array_value($link, 'title');
                  $link_target = get_array_value($link, 'target', '_self');
                  ?>
                  <li>
                    <a href="<?php echo esc_attr($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                      <?php if ($icon): ?>
                        <?php
                        if (filter_var($icon, FILTER_VALIDATE_URL) && str_ends_with($icon, '.svg')) {
                          $svg_code = @file_get_contents($icon);
                          if ($svg_code) {
                            echo $svg_code;
                          }
                        }
                        ?>
                      <?php endif; ?>
                      <?php echo esc_html($link_title); ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>

        </div>
      </div>

      <div class="footer__bottom | repel">
        <p class="footer__copyright">
          © <?php echo date('Y') ?> <?php echo $footer_company_name ?>
        </p>
        <?php
        wp_nav_menu([
          'theme_location' => 'privacy-policy',
          'container' => 'div',
          'container_class' => 'footer__policy',
          'menu_class' => 'cluster',
        ]);
        ?>
      </div>
    </div>
</footer>