<?php

function tc_normalize_page_builder_component($component, $page_context = array()) {
  $layout = isset($component['acf_fc_layout']) ? (string) $component['acf_fc_layout'] : '';

  if ($layout === 'hero') {
    return tc_normalize_hero_section($component, $page_context);
  }

  return array();
}
