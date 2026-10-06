<?php

function tc_normalize_grid_section($component) {
  $content = isset($component['grid']) && is_array($component['grid'])
    ? $component['grid']
    : $component;
  $raw_images = isset($content['images']) && is_array($content['images']) ? $content['images'] : array();
  $images = array();

  foreach ($raw_images as $raw_image) {
    if (!is_array($raw_image)) {
      continue;
    }

    $image = isset($raw_image['image']) && is_array($raw_image['image']) ? $raw_image['image'] : array();
    $image_url = is_string($image['url'] ?? null) ? esc_url(trim($image['url'])) : '';

    if ($image_url === '') {
      continue;
    }

    $caption = is_scalar($raw_image['caption'] ?? null) ? trim((string) $raw_image['caption']) : '';
    $image_alt = is_scalar($image['alt'] ?? null) ? trim((string) $image['alt']) : '';

    $images[] = array(
      'url' => $image_url,
      'alt' => $image_alt !== '' ? $image_alt : $caption,
      'caption' => $caption,
    );
  }

  if (count($images) < 3) {
    return array();
  }

  return array(
    'component' => 'grid',
    'args' => array(
      'heading' => is_scalar($content['heading'] ?? null) ? trim((string) $content['heading']) : '',
      'subtitle' => is_scalar($content['subtitle'] ?? null) ? trim((string) $content['subtitle']) : '',
      'images' => $images,
    ),
  );
}
