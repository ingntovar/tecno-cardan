<?php

function tc_normalize_contact_section($component) {
  $content = isset($component['contact']) && is_array($component['contact']) ? $component['contact'] : $component;
  $phone = tc_get_organization_phone();

  return array(
    'component' => 'contact',
    'args' => array(
      'aria_label' => trim((string) ($content['aria_label'] ?? 'Opciones de contacto')),
      'whatsapp_title' => trim((string) ($content['whatsapp_title'] ?? 'WhatsApp técnico')),
      'whatsapp_promise' => trim((string) ($content['whatsapp_promise'] ?? 'Respuesta rápida')),
      'whatsapp_copy' => trim((string) ($content['whatsapp_copy'] ?? 'Escríbenos, envíanos fotos y detalles. Te responderemos a la brevedad.')),
      'whatsapp_cta_label' => trim((string) ($content['whatsapp_cta_label'] ?? 'Escribir por WhatsApp')),
      'call_title' => trim((string) ($content['call_title'] ?? 'Llamada directa')),
      'call_promise' => trim((string) ($content['call_promise'] ?? 'Atención inmediata')),
      'call_copy' => trim((string) ($content['call_copy'] ?? 'Habla ahora con un técnico especialista y recibe asesoría al instante.')),
      'call_cta_label' => trim((string) ($content['call_cta_label'] ?? 'Llamar ahora')),
      'hours_title' => trim((string) ($content['hours_title'] ?? 'Horario de atención')),
      'trust_title' => trim((string) ($content['trust_title'] ?? 'Experiencia y confianza')),
      'trust_copy' => trim((string) ($content['trust_copy'] ?? 'Más de 20 años brindando soluciones en cardanes y transmisiones industriales.')),
      'phone' => $phone,
      'business_hours' => tc_get_grouped_business_hours(),
    ),
  );
}
