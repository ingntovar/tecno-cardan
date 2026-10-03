<?php

/**
 * Synchronize version-controlled ACF JSON into the database on demand.
 *
 * The request trigger is intentionally restricted to an authorized, nonced
 * POST request. Normal requests do not inspect or execute sync.
 */
function tc_acf_sync_from_json($approved = false) {
  if (!function_exists('acf_import_field_group') || !function_exists('acf_get_field_group_post')) {
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

  sort($files, SORT_STRING);

  $field_groups = array();
  $group_keys = array();
  $field_keys = array();
  $clone_targets = array();

  $inspect_fields = function ($fields) use (&$inspect_fields, &$field_keys, &$clone_targets) {
    if (!is_array($fields)) {
      return false;
    }

    foreach ($fields as $field) {
      if (!is_array($field) || empty($field['key']) || !is_string($field['key']) || isset($field_keys[$field['key']])) {
        return false;
      }

      $field_keys[$field['key']] = true;

      if (($field['type'] ?? '') === 'clone') {
        if (empty($field['clone']) || !is_array($field['clone'])) {
          return false;
        }

        foreach ($field['clone'] as $target) {
          if (!is_string($target) || $target === '') {
            return false;
          }

          $clone_targets[] = $target;
        }
      }

      if (isset($field['sub_fields']) && !$inspect_fields($field['sub_fields'])) {
        return false;
      }

      if (isset($field['layouts'])) {
        if (!is_array($field['layouts'])) {
          return false;
        }

        foreach ($field['layouts'] as $layout) {
          if (!is_array($layout) || !isset($layout['sub_fields']) || !$inspect_fields($layout['sub_fields'])) {
            return false;
          }
        }
      }
    }

    return true;
  };

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

    if (
      $key === ''
      || empty($field_group['title'])
      || !isset($field_group['fields'], $field_group['location'])
      || !is_array($field_group['location'])
      || isset($group_keys[$key])
      || !$inspect_fields($field_group['fields'])
    ) {
      return array(
        'success' => false,
        'message' => 'An ACF field group has an invalid structure.',
      );
    }

    $group_keys[$key] = true;
    $field_groups[] = $field_group;
  }

  foreach ($clone_targets as $target) {
    if (!isset($group_keys[$target]) && !isset($field_keys[$target])) {
      return array(
        'success' => false,
        'message' => sprintf('An ACF clone target could not be resolved: %s.', $target),
      );
    }
  }

  $updated = 0;
  $created = 0;

  foreach ($field_groups as &$field_group) {
    $key = (string) $field_group['key'];

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
  }
  unset($field_group);

  if (!$approved) {
    return array(
      'success' => true,
      'approved' => false,
      'message' => sprintf('Dry run: %d ACF field group(s) would be updated and %d created.', $updated, $created),
    );
  }

  foreach ($field_groups as $field_group) {
    $imported_group = acf_import_field_group($field_group);

    if (
      !is_array($imported_group)
      || empty($imported_group['ID'])
      || !is_numeric($imported_group['ID'])
      || (int) $imported_group['ID'] <= 0
    ) {
      return array(
        'success' => false,
        'message' => 'ACF could not import a field group.',
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
    'approved' => true,
    'message' => sprintf('%d ACF field group(s) updated, %d created.', $updated, $created),
  );
}

function tc_maybe_sync_acf_from_json() {
  static $handled = false;

  if (
    $handled
    || ($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST'
    || !isset($_POST['sync-acf-from-json'])
    || $_POST['sync-acf-from-json'] !== 'true'
    || !isset($_POST['confirm-acf-sync'])
    || $_POST['confirm-acf-sync'] !== 'approved'
  ) {
    return;
  }

  $handled = true;

  if (!current_user_can('manage_options')) {
    wp_die('You are not allowed to synchronize ACF field groups.', 'ACF synchronization denied', array('response' => 403));
  }

  check_admin_referer('tc_sync_acf_from_json');

  $result = tc_acf_sync_from_json(true);
  $status = !empty($result['success']) ? 200 : 500;
  $title = !empty($result['success']) ? 'ACF synchronization complete' : 'ACF synchronization failed';

  wp_die(
    esc_html($result['message']),
    esc_html($title),
    array('response' => $status)
  );
}

add_action('admin_init', 'tc_maybe_sync_acf_from_json');
