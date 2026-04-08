<?php

function tc_configure_images() {
  add_image_size('tc-hero', 1600, 900, true);
}

add_action('after_setup_theme', 'tc_configure_images');
