<?php

/**
 * Synchronize version-controlled ACF JSON into the database on demand.
 *
 * The request trigger is intentionally restricted to administrators and an
 * exact query-string value. Normal requests do not inspect or execute sync.
 */
function tc_acf_sync_from_json() {
  if (!function_exists('acf_update_field_group') || !function_exists('acf_get_field_group_post')) {
    return array(
      'success' => false,
      'message' => 'ACF Pro is required to synchronize field groups.',
    );
  }

  $source_path = get_stylesheet_directory() . '/includes/acf/json-sync';

  if (!is_dir($source_path)) {
    return array(
      'success' => false,
      'message' => 'The ACF JSON directory could not be found.',
    );
  }

  $files = glob($source_path . '/*.json');

  if (!is_array($files) || empty($files)) {
    return array(
      'success' => false,
      'message' => 'No ACF JSON files were found.',
    );
  }

  $updated = 0;
  $created = 0;

  foreach ($files as $file) {
    $json = file_get_contents($file);
    $field_group = is_string($json) ? json_decode($json, true) : null;

    if (!is_array($field_group) || json_last_error() !== JSON_ERROR_NONE) {
      return array(
        'success' => false,
        'message' => 'An ACF JSON file is invalid.',
      );
    }

    $key = isset($field_group['key']) ? (string) $field_group['key'] : '';

    if ($key === '' || empty($field_group['title']) || !isset($field_group['fields'], $field_group['location'])) {
      return array(
        'success' => false,
        'message' => 'An ACF field group has an invalid structure.',
      );
    }

    $existing_group_post = acf_get_field_group_post($key);

    if ($existing_group_post instanceof WP_Post) {
      if (!isset($existing_group_post->ID) || !is_numeric($existing_group_post->ID) || (int) $existing_group_post->ID <= 0) {
        return array(
          'success' => false,
          'message' => 'An existing ACF field group has an invalid database ID.',
        );
      }

      $field_group['ID'] = (int) $existing_group_post->ID;
      $updated++;
    } else {
      $created++;
    }

    $updated_group = acf_update_field_group($field_group);

    if (!is_array($updated_group)) {
      return array(
        'success' => false,
        'message' => 'ACF could not update a field group.',
      );
    }
  }

  if ($updated + $created === 0) {
    return array(
      'success' => false,
      'message' => 'No ACF field groups were synchronized.',
    );
  }

  return array(
    'success' => true,
    'message' => sprintf('%d ACF field group(s) updated, %d created.', $updated, $created),
  );
}

function tc_maybe_sync_acf_from_json() {
  static $handled = false;

  if ($handled || !isset($_GET['sync-acf-from-json']) || $_GET['sync-acf-from-json'] !== 'true') {
    return;
  }

  $handled = true;

  if (!current_user_can('manage_options')) {
    return;
  }

  $result = tc_acf_sync_from_json();
  $status = !empty($result['success']) ? 200 : 500;
  $title = !empty($result['success']) ? 'ACF synchronization complete' : 'ACF synchronization failed';

  wp_die(
    esc_html($result['message']),
    esc_html($title),
    array('response' => $status)
  );
}

add_action('admin_init', 'tc_maybe_sync_acf_from_json');
