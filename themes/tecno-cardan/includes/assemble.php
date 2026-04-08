<?php

function tc_assemble_template($page_name, $exclude_nav = false) {
  $theme_dir = get_template_directory();
  $page_path = $theme_dir . '/pages/' . $page_name . '.php';

  if (!file_exists($page_path)) {
    $page_name = 'status404';
    $page_path = $theme_dir . '/pages/status404.php';
    status_header(404);
  }

  include $theme_dir . '/pages/partials/header.php';

  if (!$exclude_nav) {
    include $theme_dir . '/pages/partials/nav.php';
  }

  echo '<main class="tc-main">';
  include $page_path;
  echo '</main>';

  include $theme_dir . '/pages/partials/footer.php';
}
