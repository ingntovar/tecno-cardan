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

function tc_set_cloned_cta_text_default($field) {
  if (
    ($field['_clone'] ?? '') === 'field_69d6a11c8f2e8'
    && ($field['key'] ?? '') === 'field_69d5c07fb86fa'
  ) {
    $field['default_value'] = 'MÁS INFORMACIÓN';
  }

  return $field;
}
add_filter('acf/clone_field', 'tc_set_cloned_cta_text_default');
