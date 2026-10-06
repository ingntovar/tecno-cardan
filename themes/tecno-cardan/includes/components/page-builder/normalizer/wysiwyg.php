<?php

function tc_normalize_wysiwyg_section($component) {
  $component = is_array($component) ? $component : array();
  $content = isset($component['wysiwyg']) && is_array($component['wysiwyg'])
    ? $component['wysiwyg']
    : $component;
  $html = is_scalar($content['content'] ?? null) ? trim((string) $content['content']) : '';

  if ($html === '') {
    return array();
  }

  return array(
    'component' => 'wysiwyg',
    'args' => array(
      'content' => $html,
    ),
  );
}
