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
