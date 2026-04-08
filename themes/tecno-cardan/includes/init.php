<?php

function tc_setup_theme() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
    )
  );

  register_nav_menus(
    array(
      'primary' => __('Primary Navigation', 'tecno-cardan'),
    )
  );
}

add_action('after_setup_theme', 'tc_setup_theme');
