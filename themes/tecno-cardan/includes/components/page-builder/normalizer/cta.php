<?php

function tc_normalize_cta($cta) {
  if (!is_array($cta)) {
    return array();
  }

  $link = isset($cta['url']) && is_array($cta['url']) ? $cta['url'] : array();

  if (!is_string($link['url'] ?? null) || !is_string($link['title'] ?? null)) {
    return array();
  }

  $url = esc_url(trim($link['url']));
  $title = trim($link['title']);

  if ($url === '' || $title === '') {
    return array();
  }

  return array(
    'url' => $url,
    'title' => $title,
    'target' => isset($link['target']) && $link['target'] === '_blank' ? '_blank' : '_self',
  );
}
