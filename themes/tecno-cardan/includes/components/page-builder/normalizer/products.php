<?php

function tc_normalize_products_section($component) {
  $content = $component;
  $raw_products = isset($component['products']) && is_array($component['products']) ? $component['products'] : array();
  $products = array();

  foreach ($raw_products as $raw_product) {
    if (!is_array($raw_product)) {
      continue;
    }

    $image = isset($raw_product['image']) && is_array($raw_product['image']) ? $raw_product['image'] : array();
    $image_url = is_string($image['url'] ?? null) ? esc_url(trim($image['url'])) : '';
    $title = is_scalar($raw_product['title'] ?? null) ? trim((string) $raw_product['title']) : '';

    if ($image_url === '' || $title === '') {
      continue;
    }

    $products[] = array(
      'image_url' => $image_url,
      'image_alt' => is_scalar($image['alt'] ?? null) ? trim((string) $image['alt']) : $title,
      'badge' => is_scalar($raw_product['badge'] ?? null) ? trim((string) $raw_product['badge']) : '',
      'title' => $title,
      'description' => is_scalar($raw_product['description'] ?? null) ? trim((string) $raw_product['description']) : '',
      'cta' => tc_normalize_cta(isset($raw_product['cta']) && is_array($raw_product['cta']) ? $raw_product['cta'] : array()),
    );
  }

  if (empty($products)) {
    return array();
  }

  return array(
    'component' => 'products',
    'args' => array(
      'eyebrow' => is_scalar($content['eyebrow'] ?? null) ? trim((string) $content['eyebrow']) : '',
      'heading' => is_scalar($content['heading'] ?? null) ? trim((string) $content['heading']) : '',
      'intro' => is_scalar($content['intro'] ?? null) ? trim((string) $content['intro']) : '',
      'products' => $products,
    ),
  );
}
