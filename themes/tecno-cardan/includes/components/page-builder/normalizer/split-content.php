<?php

function tc_normalize_split_content_section($component) {
  $content = isset($component['split_content']) && is_array($component['split_content'])
    ? $component['split_content']
    : $component;

  $image = isset($content['image']) && is_array($content['image']) ? $content['image'] : array();
  $image_url = esc_url(trim((string) ($image['url'] ?? '')));
  $image_alt = trim((string) ($content['image_alt'] ?? ''));
  $image_on_right = (bool) ($content['image_on_right'] ?? false);
  $logo_url = tc_get_three_column_icon_url($content['logo'] ?? '');
  $title_prefix = trim((string) ($content['title_prefix'] ?? ''));
  $title_highlight = trim((string) ($content['title_highlight'] ?? ''));
  $title_suffix = trim((string) ($content['title_suffix'] ?? ''));
  $description = is_scalar($content['description'] ?? null)
    ? trim((string) $content['description'])
    : '';
  $cta = tc_normalize_cta(isset($content['cta']) && is_array($content['cta']) ? $content['cta'] : array());

  if ($image_url === '' || $image_alt === '' || $title_prefix === '' || $description === '' || empty($cta) || esc_url($cta['url']) === '') {
    return null;
  }

  return array(
    'component' => 'split-content',
    'args' => array(
      'image_url' => $image_url,
      'image_alt' => $image_alt,
      'image_on_right' => $image_on_right,
      'logo_url' => $logo_url,
      'title_prefix' => $title_prefix,
      'title_highlight' => $title_highlight,
      'title_suffix' => $title_suffix,
      'description' => $description,
      'cta' => $cta,
    ),
  );
}
