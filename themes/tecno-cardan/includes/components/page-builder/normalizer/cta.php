<?php

function tc_normalize_cta($cta) {
  if (!is_array($cta)) {
    return array();
  }

  $text = trim((string) ($cta['text'] ?? ''));
  $url = trim((string) ($cta['url'] ?? ''));

  if ($text === '' || $url === '') {
    return array();
  }

  return array(
    'text' => $text,
    'url' => $url,
    'is_blank' => !empty($cta['is_blank']),
  );
}
