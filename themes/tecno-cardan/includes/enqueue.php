<?php

function tc_enqueue_assets() {
  $build_dir = get_template_directory() . '/build';
  $build_uri = get_template_directory_uri() . '/build';
  $asset_path = $build_dir . '/index.asset.php';
  $style_path = $build_dir . '/index.css';
  $script_path = $build_dir . '/index.js';
  $asset = file_exists($asset_path) ? require $asset_path : array(
    'dependencies' => array(),
    'version' => null,
  );

  if (file_exists($style_path)) {
    wp_enqueue_style(
      'tc-theme-style',
      $build_uri . '/index.css',
      array(),
      isset($asset['version']) ? $asset['version'] : (string) filemtime($style_path)
    );
  }

  if (file_exists($script_path)) {
    wp_enqueue_script(
      'tc-theme-script',
      $build_uri . '/index.js',
      isset($asset['dependencies']) ? $asset['dependencies'] : array(),
      isset($asset['version']) ? $asset['version'] : (string) filemtime($script_path),
      true
    );
  }
}

add_action('wp_enqueue_scripts', 'tc_enqueue_assets');
