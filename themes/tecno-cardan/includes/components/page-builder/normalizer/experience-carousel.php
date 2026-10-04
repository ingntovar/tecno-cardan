<?php

function tc_normalize_experience_carousel_section($component) {
  $content = isset($component['experience_carousel']) && is_array($component['experience_carousel'])
    ? $component['experience_carousel']
    : $component;
  $show_content = !array_key_exists('show_content', $content) || !empty($content['show_content']);
  $raw_slides = isset($content['slides']) && is_array($content['slides']) ? $content['slides'] : array();
  $slides = array();

  foreach ($raw_slides as $raw_slide) {
    if (!is_array($raw_slide)) {
      continue;
    }

    $image = isset($raw_slide['image']) && is_array($raw_slide['image']) ? $raw_slide['image'] : array();
    $image_url = is_string($image['url'] ?? null) ? esc_url(trim($image['url'])) : '';

    if ($image_url === '') {
      continue;
    }

    $description = is_scalar($raw_slide['description'] ?? null)
      ? trim(str_replace(array("\r\n", "\r"), "\n", (string) $raw_slide['description']))
      : '';
    $show_cta = $show_content && !empty($raw_slide['show_cta']);

    if ($show_content && $description === '') {
      continue;
    }

    $slides[] = array(
      'media_title' => is_scalar($raw_slide['media_title'] ?? null) ? trim((string) $raw_slide['media_title']) : '',
      'image_url' => $image_url,
      'image_alt' => is_scalar($image['alt'] ?? null) ? trim((string) $image['alt']) : '',
      'title' => $show_content && is_scalar($raw_slide['title'] ?? null) ? trim((string) $raw_slide['title']) : '',
      'description' => $show_content ? $description : '',
      'cta' => $show_cta
        ? tc_normalize_cta(isset($raw_slide['cta']) && is_array($raw_slide['cta']) ? $raw_slide['cta'] : array())
        : array(),
    );
  }

  if (empty($slides)) {
    return array();
  }

  return array(
    'component' => 'experience-carousel',
    'args' => array(
      'slides' => $slides,
      'show_content' => $show_content,
    ),
  );
}
