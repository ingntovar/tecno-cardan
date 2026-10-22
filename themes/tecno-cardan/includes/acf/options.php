<?php

function tc_register_options_page() {
  if (!function_exists('acf_add_options_page')) {
    return;
  }

  acf_add_options_page(
    array(
      'page_title' => 'Configuración del sitio',
      'menu_title' => 'Configuración del sitio',
      'menu_slug' => 'tc-site-settings',
      'capability' => 'manage_options',
      'redirect' => false,
      'position' => 61,
      'icon_url' => 'dashicons-admin-settings',
      'update_button' => 'Guardar configuración',
      'updated_message' => 'Configuración guardada.',
    )
  );
}

add_action('acf/init', 'tc_register_options_page');

function tc_get_organization_phone() {
  $fallback = '+57 300 123 4567';
  $phone = $fallback;

  if (function_exists('get_field')) {
    $configured_phone = get_field('organization_phone', 'option');

    if (is_scalar($configured_phone) && trim((string) $configured_phone) !== '') {
      $phone = trim((string) $configured_phone);
    }
  }

  $digits = preg_replace('/\D+/', '', $phone);

  if (!is_string($digits) || $digits === '') {
    $phone = $fallback;
    $digits = '573001234567';
  }

  return array(
    'display' => $phone,
    'tel_url' => 'tel:+' . $digits,
    'whatsapp_url' => 'https://wa.me/' . $digits,
  );
}

function tc_get_default_business_hours() {
  $weekday_shifts = array(
    array('opens_at' => '08:00', 'closes_at' => '18:00'),
  );

  return array(
    'monday' => array('is_open' => true, 'shifts' => $weekday_shifts),
    'tuesday' => array('is_open' => true, 'shifts' => $weekday_shifts),
    'wednesday' => array('is_open' => true, 'shifts' => $weekday_shifts),
    'thursday' => array('is_open' => true, 'shifts' => $weekday_shifts),
    'friday' => array('is_open' => true, 'shifts' => $weekday_shifts),
    'saturday' => array(
      'is_open' => true,
      'shifts' => array(
        array('opens_at' => '08:00', 'closes_at' => '13:00'),
      ),
    ),
    'sunday' => array('is_open' => false, 'shifts' => array()),
  );
}

function tc_normalize_business_day($day, $fallback) {
  if (!is_array($day)) {
    return $fallback;
  }

  $is_open = !empty($day['is_open']);
  $shifts = array();
  $raw_shifts = isset($day['shifts']) && is_array($day['shifts']) ? $day['shifts'] : array();

  if ($is_open) {
    foreach ($raw_shifts as $shift) {
      if (!is_array($shift)) {
        continue;
      }

      $opens_at = is_scalar($shift['opens_at'] ?? null) ? trim((string) $shift['opens_at']) : '';
      $closes_at = is_scalar($shift['closes_at'] ?? null) ? trim((string) $shift['closes_at']) : '';

      if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $opens_at) || !preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $closes_at)) {
        continue;
      }

      $shifts[] = array(
        'opens_at' => $opens_at,
        'closes_at' => $closes_at,
      );
    }
  }

  if ($is_open && empty($shifts)) {
    return $fallback;
  }

  return array(
    'is_open' => $is_open,
    'shifts' => $shifts,
  );
}

function tc_format_business_time($time) {
  $parts = explode(':', (string) $time);

  if (count($parts) !== 2) {
    return '';
  }

  $hour = (int) $parts[0];
  $minute = (int) $parts[1];
  $period = $hour < 12 ? 'a.m.' : 'p.m.';
  $display_hour = $hour % 12;

  if ($display_hour === 0) {
    $display_hour = 12;
  }

  return sprintf('%d:%02d %s', $display_hour, $minute, $period);
}

function tc_get_grouped_business_hours() {
  $day_labels = array(
    'monday' => 'Lunes',
    'tuesday' => 'Martes',
    'wednesday' => 'Miércoles',
    'thursday' => 'Jueves',
    'friday' => 'Viernes',
    'saturday' => 'Sábado',
    'sunday' => 'Domingo',
  );
  $schedule = tc_get_default_business_hours();

  if (function_exists('get_field')) {
    $configured_schedule = get_field('business_hours', 'option');

    if (is_array($configured_schedule)) {
      foreach (array_keys($day_labels) as $day_key) {
        $schedule[$day_key] = tc_normalize_business_day(
          $configured_schedule[$day_key] ?? null,
          $schedule[$day_key]
        );
      }
    }
  }

  $groups = array();

  foreach ($day_labels as $day_key => $day_label) {
    $day = $schedule[$day_key];
    $signature = wp_json_encode($day);
    $last_index = count($groups) - 1;

    if ($last_index >= 0 && $groups[$last_index]['signature'] === $signature) {
      $groups[$last_index]['end_label'] = $day_label;
      continue;
    }

    $groups[] = array(
      'start_label' => $day_label,
      'end_label' => $day_label,
      'signature' => $signature,
      'is_open' => $day['is_open'],
      'shifts' => $day['shifts'],
    );
  }

  return array_map(
    function ($group) {
      $shift_labels = array();

      foreach ($group['shifts'] as $shift) {
        $shift_labels[] = tc_format_business_time($shift['opens_at']) . ' – ' . tc_format_business_time($shift['closes_at']);
      }

      return array(
        'days' => $group['start_label'] === $group['end_label']
          ? $group['start_label']
          : $group['start_label'] . ' a ' . strtolower($group['end_label']),
        'hours' => $group['is_open'] ? implode(' / ', $shift_labels) : 'Cerrado',
      );
    },
    $groups
  );
}
