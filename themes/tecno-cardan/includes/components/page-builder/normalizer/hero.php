<?php

function tc_normalize_hero_section($component, $page_context = array()) {
  $hero = isset($component['hero']) && is_array($component['hero']) ? $component['hero'] : $component;

  $title = trim((string) ($hero['title'] ?? ''));
  $copy = trim((string) ($hero['copy'] ?? ''));
  $include_page_data = !empty($page_context['include_page_data']);

  if ($include_page_data && $title === '') {
    $title = trim((string) ($page_context['heading'] ?? ''));
  }

  if ($include_page_data && $copy === '') {
    $copy = trim((string) ($page_context['copy'] ?? ''));
  }

  $image = isset($hero['image']) && is_array($hero['image']) ? $hero['image'] : array();
  $background_image_url = trim((string) ($image['url'] ?? ''));
  $cta = tc_normalize_cta(isset($hero['cta']) && is_array($hero['cta']) ? $hero['cta'] : array());

  if ($title === '' && $copy === '' && empty($cta) && $background_image_url === '') {
    return array();
  }

  return array(
    'component' => 'hero',
    'args' => array(
      'title' => $title,
      'copy' => $copy,
      'cta' => $cta,
      'background_image_url' => $background_image_url,
    ),
  );
}
