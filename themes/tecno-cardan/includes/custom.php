<?php

function tc_footer_fallback_menu() {
  echo '<ul class="tc-site-footer__nav-list">';
  echo '<li><a href="' . esc_url(home_url('/')) . '">Inicio</a></li>';
  echo '<li><a href="' . esc_url(home_url('/#nosotros')) . '">Nosotros</a></li>';
  echo '<li><a href="' . esc_url(home_url('/#servicios')) . '">Servicios</a></li>';
  echo '<li><a href="' . esc_url(home_url('/#trabajos')) . '">Trabajos</a></li>';
  echo '<li><a href="' . esc_url(home_url('/#contacto')) . '">Contacto</a></li>';
  echo '</ul>';
}

function tc_add_split_content_wysiwyg_toolbar($toolbars) {
  $toolbars['Split Content Bold'] = array(
    1 => array('bold'),
  );

  return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'tc_add_split_content_wysiwyg_toolbar');
