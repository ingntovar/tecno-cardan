<?php

$page_id = (int) get_queried_object_id();

if ($page_id <= 0) {
  $page_id = (int) get_the_ID();
}

$sections = tc_get_page_builder_sections($page_id);

foreach ($sections as $section) {
  if (!is_array($section)) {
    continue;
  }

  $component_name = isset($section['component']) ? (string) $section['component'] : '';
  $component_args = isset($section['args']) && is_array($section['args']) ? $section['args'] : array();

  if ($component_name === '') {
    continue;
  }

  tc_render_component($component_name, $component_args);
}

