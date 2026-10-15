<?php

$site_name = get_bloginfo('name');
$home_url = home_url('/');
$whatsapp_url = 'https://wa.me/573001234567';
?>
<header class="tc-navbar" data-js-navbar>
  <div class="tc-navbar__top">
    <div class="tc-container tc-navbar__top-inner">
      <a class="tc-navbar__brand" href="<?php echo esc_url($home_url); ?>" aria-label="<?php echo esc_attr($site_name); ?>">
        <span class="tc-navbar__brand-mark" aria-hidden="true">TC</span>
        <span class="tc-navbar__brand-name"><?php echo esc_html($site_name); ?></span>
      </a>

      <a
        class="tc-navbar__whatsapp tc-navbar__whatsapp--desktop"
        href="<?php echo esc_url($whatsapp_url); ?>"
        target="_blank"
        rel="noopener noreferrer"
      >
        <span class="tc-navbar__whatsapp-icon" aria-hidden="true">
          <svg viewBox="0 0 32 32" width="24" height="24" focusable="false">
            <path fill="currentColor" d="M16.04 3C8.84 3 3 8.7 3 15.74c0 2.25.61 4.45 1.76 6.37L3 29l7.07-1.82a13.32 13.32 0 0 0 5.96 1.43h.01C23.24 28.61 29 22.91 29 15.87 29 8.82 23.24 3 16.04 3Zm7.57 18.23c-.32.88-1.88 1.69-2.58 1.78-.66.09-1.5.13-2.42-.15-.56-.17-1.28-.41-2.21-.81-3.89-1.65-6.43-5.49-6.62-5.75-.19-.25-1.58-2.06-1.58-3.93 0-1.87.99-2.79 1.34-3.17.35-.38.77-.47 1.03-.47h.74c.24.01.56-.09.87.65.32.76 1.09 2.63 1.18 2.82.1.19.16.41.03.66-.13.25-.19.41-.39.63-.19.22-.41.49-.58.66-.19.19-.39.4-.17.78.23.38 1.01 1.63 2.17 2.64 1.49 1.3 2.75 1.7 3.14 1.89.39.19.62.16.84-.09.23-.25.97-1.11 1.23-1.49.26-.38.52-.31.87-.19.35.13 2.24 1.03 2.62 1.22.39.19.65.28.74.44.1.16.1.91-.22 1.79Z" />
          </svg>
        </span>
        <span>
          <span class="tc-navbar__whatsapp-label">COTIZA POR WHATSAPP</span>
          <span class="tc-navbar__whatsapp-number">+57 300 123 4567</span>
        </span>
      </a>

      <div class="tc-navbar__mobile-actions">
        <a
          class="tc-navbar__whatsapp tc-navbar__whatsapp--mobile"
          href="<?php echo esc_url($whatsapp_url); ?>"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="Contactar por WhatsApp"
        >
          <svg viewBox="0 0 32 32" width="22" height="22" aria-hidden="true" focusable="false">
            <path fill="currentColor" d="M16.04 3C8.84 3 3 8.7 3 15.74c0 2.25.61 4.45 1.76 6.37L3 29l7.07-1.82a13.32 13.32 0 0 0 5.96 1.43h.01C23.24 28.61 29 22.91 29 15.87 29 8.82 23.24 3 16.04 3Zm7.57 18.23c-.32.88-1.88 1.69-2.58 1.78-.66.09-1.5.13-2.42-.15-.56-.17-1.28-.41-2.21-.81-3.89-1.65-6.43-5.49-6.62-5.75-.19-.25-1.58-2.06-1.58-3.93 0-1.87.99-2.79 1.34-3.17.35-.38.77-.47 1.03-.47h.74c.24.01.56-.09.87.65.32.76 1.09 2.63 1.18 2.82.1.19.16.41.03.66-.13.25-.19.41-.39.63-.19.22-.41.49-.58.66-.19.19-.39.4-.17.78.23.38 1.01 1.63 2.17 2.64 1.49 1.3 2.75 1.7 3.14 1.89.39.19.62.16.84-.09.23-.25.97-1.11 1.23-1.49.26-.38.52-.31.87-.19.35.13 2.24 1.03 2.62 1.22.39.19.65.28.74.44.1.16.1.91-.22 1.79Z" />
          </svg>
          <span>WhatsApp</span>
        </a>

        <button
          class="tc-navbar__menu-button"
          type="button"
          data-js-navbar-toggle
          aria-controls="tc-navbar-menu"
          aria-expanded="false"
          aria-label="Abrir menú"
        >
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </div>

  <div class="tc-navbar__nav-bar" data-js-navbar-panel>
    <div class="tc-container">
      <nav id="tc-navbar-menu" class="tc-navbar__nav" aria-label="Navegación principal" aria-hidden="false">
        <?php
        $menu = wp_nav_menu(
          array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'tc-navbar__menu',
            'fallback_cb' => false,
            'depth' => 1,
            'echo' => false,
          )
        );

        if ($menu) :
          echo $menu;
        else :
          ?>
          <ul class="tc-navbar__menu tc-navbar__menu--fallback">
            <li><a class="tc-navbar__link tc-navbar__link--active" href="<?php echo esc_url($home_url); ?>">Inicio</a></li>
            <li><a class="tc-navbar__link" href="<?php echo esc_url(home_url('/#servicios')); ?>">Servicios</a></li>
            <li><a class="tc-navbar__link" href="<?php echo esc_url(home_url('/#nosotros')); ?>">Nosotros</a></li>
            <li><a class="tc-navbar__link" href="<?php echo esc_url(home_url('/#trabajos')); ?>">Trabajos</a></li>
            <li><a class="tc-navbar__link" href="<?php echo esc_url(home_url('/#contacto')); ?>">Contacto</a></li>
          </ul>
          <?php
        endif;
        ?>
        <a
          class="tc-navbar__whatsapp tc-navbar__mobile-cta"
          href="<?php echo esc_url($whatsapp_url); ?>"
          target="_blank"
          rel="noopener noreferrer"
        >
          <svg viewBox="0 0 32 32" width="21" height="21" aria-hidden="true" focusable="false">
            <path fill="currentColor" d="M16.04 3C8.84 3 3 8.7 3 15.74c0 2.25.61 4.45 1.76 6.37L3 29l7.07-1.82a13.32 13.32 0 0 0 5.96 1.43h.01C23.24 28.61 29 22.91 29 15.87 29 8.82 23.24 3 16.04 3Zm7.57 18.23c-.32.88-1.88 1.69-2.58 1.78-.66.09-1.5.13-2.42-.15-.56-.17-1.28-.41-2.21-.81-3.89-1.65-6.43-5.49-6.62-5.75-.19-.25-1.58-2.06-1.58-3.93 0-1.87.99-2.79 1.34-3.17.35-.38.77-.47 1.03-.47h.74c.24.01.56-.09.87.65.32.76 1.09 2.63 1.18 2.82.1.19.16.41.03.66-.13.25-.19.41-.39.63-.19.22-.41.49-.58.66-.19.19-.39.4-.17.78.23.38 1.01 1.63 2.17 2.64 1.49 1.3 2.75 1.7 3.14 1.89.39.19.62.16.84-.09.23-.25.97-1.11 1.23-1.49.26-.38.52-.31.87-.19.35.13 2.24 1.03 2.62 1.22.39.19.65.28.74.44.1.16.1.91-.22 1.79Z" />
          </svg>
          <span>Cotiza por WhatsApp</span>
        </a>
      </nav>
    </div>
  </div>
</header>
