<?php

function tc_get_page_builder_context($post_id) {
  $context = array(
    'include_page_data' => false,
    'heading' => '',
    'copy' => '',
  );

  $post_id = (int) $post_id;

  if ($post_id <= 0 || !function_exists('get_field')) {
    return $context;
  }

  $context['include_page_data'] = (bool) get_field('include_page_data', $post_id);
  $context['heading'] = trim((string) get_field('heading', $post_id));
  $context['copy'] = trim((string) get_field('copy', $post_id));

  return $context;
}

function tc_get_page_builder_sections($post_id) {
  $post_id = (int) $post_id;

  if ($post_id <= 0 || !function_exists('get_field')) {
    return array();
  }

  $components = get_field('components', $post_id);

  if (!is_array($components) || empty($components)) {
    return array();
  }

  $page_context = tc_get_page_builder_context($post_id);
  $sections = array();

  foreach ($components as $component) {
    if (!is_array($component)) {
      continue;
    }

    $section = tc_normalize_page_builder_component($component, $page_context);

    if (!is_array($section)) {
      continue;
    }

    $component_name = isset($section['component']) ? (string) $section['component'] : '';
    $args = isset($section['args']) && is_array($section['args']) ? $section['args'] : array();

    if ($component_name === '') {
      continue;
    }

    $sections[] = array(
      'component' => $component_name,
      'args' => $args,
    );
  }

  return $sections;
}
