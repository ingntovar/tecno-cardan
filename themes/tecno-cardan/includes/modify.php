<?php

function tc_cleanup_wp_head() {
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
}

function tc_disable_block_editor_for_pages($use_block_editor, $post_type) {
  if ($post_type === 'page') {
    return false;
  }

  return $use_block_editor;
}

add_action('init', 'tc_cleanup_wp_head');
add_filter('use_block_editor_for_post_type', 'tc_disable_block_editor_for_pages', 10, 2);
