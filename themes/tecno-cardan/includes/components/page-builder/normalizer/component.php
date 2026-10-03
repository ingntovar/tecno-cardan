<?php

function tc_normalize_page_builder_component($component, $page_context = array()) {
  $layout = isset($component['acf_fc_layout']) ? (string) $component['acf_fc_layout'] : '';

  if ($layout === 'hero') {
    return tc_normalize_hero_section($component, $page_context);
  }

  if ($layout === 'three-colimn-content') {
    return tc_normalize_three_colimn_content_section($component);
  }

  if ($layout === 'split-content') {
    return tc_normalize_split_content_section($component);
  }

  return array();
}
