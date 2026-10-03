<?php

function tc_fallback_menu() {
  echo '<ul class="tc-fallback-menu">';
  wp_list_pages(
    array(
      'title_li' => '',
      'depth' => 1,
    )
  );
  echo '</ul>';
}

function tc_add_split_content_wysiwyg_toolbar($toolbars) {
  $toolbars['Split Content Bold'] = array(
    1 => array('bold'),
  );

  return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'tc_add_split_content_wysiwyg_toolbar');
