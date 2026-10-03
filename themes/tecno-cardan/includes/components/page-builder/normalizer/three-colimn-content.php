<?php

function tc_normalize_three_colimn_content_section($component) {
  $content = isset($component['three_colimn_content']) && is_array($component['three_colimn_content'])
    ? $component['three_colimn_content']
    : $component;

  $content_enabled = !empty($content['enable_column_content']);
  $normalize_content = function ($value) {
    if (!is_scalar($value)) {
      return '';
    }

    return trim(str_replace(array("\r\n", "\r"), "\n", (string) $value));
  };

  $cards = array(
    array(
      'icon_url' => tc_get_three_column_icon_url($content['first_icon'] ?? ''),
      'number' => trim((string) ($content['first_number'] ?? '')),
      'description' => trim((string) ($content['first_description'] ?? '')),
      'description_strong' => false,
      'title' => '',
      'content' => $content_enabled ? $normalize_content($content['first_content'] ?? '') : '',
      'hidden' => !empty($content['hide_first']),
    ),
    array(
      'icon_url' => tc_get_three_column_icon_url($content['second_icon'] ?? ''),
      'number' => trim((string) ($content['second_number'] ?? '')),
      'description' => trim((string) ($content['second_description'] ?? '')),
      'description_strong' => true,
      'title' => '',
      'content' => $content_enabled ? $normalize_content($content['second_content'] ?? '') : '',
      'hidden' => !empty($content['hide_second']),
    ),
    array(
      'icon_url' => tc_get_three_column_icon_url($content['third_icon'] ?? ''),
      'number' => '',
      'description' => '',
      'description_strong' => false,
      'title' => trim((string) ($content['third_title'] ?? '')),
      'content' => $content_enabled ? $normalize_content($content['third_content'] ?? '') : '',
      'hidden' => !empty($content['hide_third']),
    ),
  );

  $cards = array_values(array_filter($cards, function ($card) {
    return empty($card['hidden']);
  }));

  foreach ($cards as $card) {
    if ($card['icon_url'] !== '' || $card['number'] !== '' || $card['description'] !== '' || $card['title'] !== '' || $card['content'] !== '') {
      return array(
        'component' => 'three-colimn-content',
        'args' => array(
          'content_enabled' => $content_enabled,
          'cards' => $cards,
        ),
      );
    }
  }

  return array();
}

function tc_get_three_column_icon_url($value) {
  $allowed_icons = array('experience', 'driveshaft', 'technician');

  if (is_string($value) && in_array($value, $allowed_icons, true)) {
    return tc_get_asset_url('assets/img/icons/icon-' . $value . '.svg');
  }

  // Keep old uploaded-image values renderable until their content is migrated.
  if (is_array($value)) {
    return trim((string) ($value['url'] ?? ''));
  }

  return '';
}
