<?php
$aria_label = isset($aria_label) && $aria_label !== '' ? $aria_label : 'Opciones de contacto';
$whatsapp_title = isset($whatsapp_title) ? (string) $whatsapp_title : 'WhatsApp técnico';
$whatsapp_promise = isset($whatsapp_promise) ? (string) $whatsapp_promise : 'Respuesta rápida';
$whatsapp_copy = isset($whatsapp_copy) ? (string) $whatsapp_copy : 'Escríbenos, envíanos fotos y detalles. Te responderemos a la brevedad.';
$whatsapp_cta_label = isset($whatsapp_cta_label) ? (string) $whatsapp_cta_label : 'Escribir por WhatsApp';
$call_title = isset($call_title) ? (string) $call_title : 'Llamada directa';
$call_promise = isset($call_promise) ? (string) $call_promise : 'Atención inmediata';
$call_copy = isset($call_copy) ? (string) $call_copy : 'Habla ahora con un técnico especialista y recibe asesoría al instante.';
$call_cta_label = isset($call_cta_label) ? (string) $call_cta_label : 'Llamar ahora';
$hours_title = isset($hours_title) ? (string) $hours_title : 'Horario de atención';
$trust_title = isset($trust_title) ? (string) $trust_title : 'Experiencia y confianza';
$trust_copy = isset($trust_copy) ? (string) $trust_copy : 'Más de 20 años brindando soluciones en cardanes y transmisiones industriales.';
$phone = isset($phone) && is_array($phone) ? $phone : array();
$phone_display = isset($phone['display']) ? (string) $phone['display'] : '+57 300 123 4567';
$tel_url = isset($phone['tel_url']) ? (string) $phone['tel_url'] : 'tel:+573001234567';
$whatsapp_url = isset($phone['whatsapp_url']) ? (string) $phone['whatsapp_url'] : 'https://wa.me/573001234567';
$business_hours = isset($business_hours) && is_array($business_hours) ? $business_hours : array();
?>
<section class="contact-options" aria-label="<?php echo esc_attr($aria_label); ?>">
  <div class="contact-options__container">
    <div class="contact-options__primary">
      <article class="contact-options__card contact-options__card--whatsapp">
        <div class="contact-options__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="currentColor" focusable="false">
            <path d="M12 2a9.8 9.8 0 0 0-8.4 14.9L2 22l5.2-1.5A10 10 0 1 0 12 2Zm0 17.8a7.8 7.8 0 0 1-4-1.1l-.3-.2-3.1.9.9-3-.2-.3A7.8 7.8 0 1 1 12 19.8Zm4.3-5.8c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1a6.4 6.4 0 0 1-1.9-1.2 7 7 0 0 1-1.3-1.7c-.1-.2 0-.4.1-.5l.4-.5.2-.4c.1-.2 0-.4 0-.5l-.7-1.7c-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.2.2-.9.9-.9 2.1 0 1.3.9 2.5 1 2.7.1.2 1.8 2.8 4.5 3.9.6.3 1.1.4 1.5.5.6.2 1.2.2 1.7.1.5-.1 1.4-.6 1.6-1.1.2-.5.2-1 .2-1.1-.1-.2-.2-.3-.4-.4Z" />
          </svg>
        </div>
        <h2 class="contact-options__title"><?php echo esc_html($whatsapp_title); ?></h2>
        <p class="contact-options__promise"><?php echo esc_html($whatsapp_promise); ?></p>
        <p class="contact-options__copy"><?php echo nl2br(esc_html($whatsapp_copy)); ?></p>
        <a class="contact-options__cta" href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener noreferrer">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
            <path d="M12 2a9.8 9.8 0 0 0-8.4 14.9L2 22l5.2-1.5A10 10 0 1 0 12 2Zm0 17.8a7.8 7.8 0 0 1-4-1.1l-.3-.2-3.1.9.9-3-.2-.3A7.8 7.8 0 1 1 12 19.8Zm4.3-5.8c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1a6.4 6.4 0 0 1-1.9-1.2 7 7 0 0 1-1.3-1.7c-.1-.2 0-.4.1-.5l.4-.5.2-.4c.1-.2 0-.4 0-.5l-.7-1.7c-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.2.2-.9.9-.9 2.1 0 1.3.9 2.5 1 2.7.1.2 1.8 2.8 4.5 3.9.6.3 1.1.4 1.5.5.6.2 1.2.2 1.7.1.5-.1 1.4-.6 1.6-1.1.2-.5.2-1 .2-1.1-.1-.2-.2-.3-.4-.4Z" />
          </svg>
          <span><?php echo esc_html($whatsapp_cta_label); ?></span>
        </a>
        <p class="contact-options__number"><?php echo esc_html($phone_display); ?></p>
      </article>

      <article class="contact-options__card contact-options__card--call">
        <div class="contact-options__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="currentColor" focusable="false">
            <path d="M6.6 10.8a15.5 15.5 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.2 1.1l-2.3 2.1Z" />
          </svg>
        </div>
        <h2 class="contact-options__title"><?php echo esc_html($call_title); ?></h2>
        <p class="contact-options__promise"><?php echo esc_html($call_promise); ?></p>
        <p class="contact-options__copy"><?php echo nl2br(esc_html($call_copy)); ?></p>
        <a class="contact-options__cta" href="<?php echo esc_url($tel_url); ?>">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
            <path d="M6.6 10.8a15.5 15.5 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.2 1.1l-2.3 2.1Z" />
          </svg>
          <span><?php echo esc_html($call_cta_label); ?></span>
        </a>
        <p class="contact-options__number"><?php echo esc_html($phone_display); ?></p>
      </article>

      <div class="contact-options__separator" aria-hidden="true"><span>Ó</span></div>
    </div>

    <div class="contact-options__details">
      <article class="contact-options__detail">
        <div class="contact-options__detail-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" focusable="false">
            <circle cx="12" cy="12" r="9" />
            <path d="M12 7v5l3.5 2" />
          </svg>
        </div>
        <div>
          <h2 class="contact-options__detail-title"><?php echo esc_html($hours_title); ?></h2>
          <div class="contact-options__detail-copy">
            <?php foreach ($business_hours as $hours_group) : ?>
              <p><strong><?php echo esc_html($hours_group['days']); ?>:</strong> <?php echo esc_html($hours_group['hours']); ?></p>
            <?php endforeach; ?>
          </div>
        </div>
      </article>

      <article class="contact-options__detail">
        <div class="contact-options__detail-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false">
            <path d="M12 3 19 6v5c0 4.6-2.8 8-7 10-4.2-2-7-5.4-7-10V6l7-3Z" />
            <path d="m9 12 2 2 4-4" />
          </svg>
        </div>
        <div>
          <h2 class="contact-options__detail-title"><?php echo esc_html($trust_title); ?></h2>
          <p class="contact-options__detail-copy"><?php echo nl2br(esc_html($trust_copy)); ?></p>
        </div>
      </article>
    </div>
  </div>
</section>
