<?php

function tc_normalize_three_colimn_content_section($component) {
  $content = isset($component['three_colimn_content']) && is_array($component['three_colimn_content'])
    ? $component['three_colimn_content']
    : $component;

  $cards = array(
    array(
      'icon_url' => tc_get_page_builder_image_url($content['first_icon'] ?? array()),
      'number' => trim((string) ($content['first_number'] ?? '')),
      'description' => trim((string) ($content['first_description'] ?? '')),
      'description_strong' => false,
      'title' => '',
    ),
    array(
      'icon_url' => tc_get_page_builder_image_url($content['second_icon'] ?? array()),
      'number' => trim((string) ($content['second_number'] ?? '')),
      'description' => trim((string) ($content['second_description'] ?? '')),
      'description_strong' => true,
      'title' => '',
    ),
    array(
      'icon_url' => tc_get_page_builder_image_url($content['third_icon'] ?? array()),
      'number' => '',
      'description' => '',
      'description_strong' => false,
      'title' => trim((string) ($content['third_title'] ?? '')),
    ),
  );

  foreach ($cards as $card) {
    if ($card['icon_url'] !== '' || $card['number'] !== '' || $card['description'] !== '' || $card['title'] !== '') {
      return array(
        'component' => 'three-colimn-content',
        'args' => array('cards' => $cards),
      );
    }
  }

  return array();
}

function tc_get_page_builder_image_url($image) {
  if (!is_array($image)) {
    return '';
  }

  return trim((string) ($image['url'] ?? ''));
}
