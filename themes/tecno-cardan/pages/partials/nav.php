<nav class="tc-site-nav" aria-label="<?php esc_attr_e('Primary navigation', 'tecno-cardan'); ?>">
  <div class="tc-container tc-site-nav__inner">
    <?php
    wp_nav_menu(
      array(
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'tc-nav-list',
        'fallback_cb' => 'tc_fallback_menu',
      )
    );
    ?>
  </div>
</nav>
