<?php

function tc_get_asset_url($path = '') {
  $base_uri = get_template_directory_uri();

  if ($path === '') {
    return $base_uri;
  }

  return $base_uri . '/' . ltrim($path, '/');
}

function tc_render_component($component_name, $args = array()) {
  $component_path = get_template_directory() . '/pages/components/' . $component_name . '.php';

  if (!file_exists($component_path)) {
    return;
  }

  if (!empty($args)) {
    extract($args, EXTR_SKIP);
  }

  include $component_path;
}
