<?php $organization_phone = tc_get_organization_phone(); ?>
<footer class="tc-site-footer">
  <section class="tc-site-footer__cta" aria-labelledby="tc-footer-cta-title">
    <div class="tc-container tc-site-footer__cta-inner">
      <div>
        <p class="tc-site-footer__eyebrow">HABLEMOS DE TU PROYECTO</p>
        <h2 id="tc-footer-cta-title" class="tc-site-footer__cta-title">
          ¿Necesitas una solución para tu cardán?
        </h2>
        <p class="tc-site-footer__cta-copy">
          Cuéntanos qué necesitas y recibe asesoría directa para encontrar la
          solución adecuada para tu vehículo o equipo.
        </p>
      </div>

      <a class="tc-site-footer__cta-link" href="<?php echo esc_url($organization_phone['whatsapp_url']); ?>" target="_blank" rel="noopener noreferrer">
        <span class="tc-site-footer__cta-link-label">COTIZA POR WHATSAPP</span>
        <span class="tc-site-footer__cta-link-value"><?php echo esc_html($organization_phone['display']); ?></span>
      </a>
    </div>
  </section>

  <div class="tc-site-footer__main">
    <div class="tc-container tc-site-footer__grid">
      <div class="tc-site-footer__brand">
        <a class="tc-site-footer__logo" href="#inicio" aria-label="Tecno Cardan, inicio">
          TECNO CARDAN
        </a>
        <p>
          Especialistas en cardanes y transmisiones industriales, ofreciendo
          soluciones confiables para cada necesidad.
        </p>
        <span class="tc-site-footer__tagline">Experiencia · Precisión · Confianza</span>
      </div>

      <div>
        <h2 class="tc-site-footer__heading">Navegación</h2>
        <nav class="tc-site-footer__nav" aria-label="Navegación del footer">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'footer',
              'container' => false,
              'depth' => 1,
              'fallback_cb' => 'tc_footer_fallback_menu',
              'menu_class' => 'tc-site-footer__nav-list',
            )
          );
          ?>
        </nav>
      </div>

      <div id="contacto">
        <h2 class="tc-site-footer__heading">Contacto</h2>
        <address class="tc-site-footer__contact">
          <a href="<?php echo esc_url($organization_phone['whatsapp_url']); ?>" target="_blank" rel="noopener noreferrer">WhatsApp: <?php echo esc_html($organization_phone['display']); ?></a>
          <a href="<?php echo esc_url($organization_phone['tel_url']); ?>">Teléfono: <?php echo esc_html($organization_phone['display']); ?></a>
          <a href="#contacto">Correo: contacto@tecnocardan.com</a>
          <span>Bogotá, Colombia</span>
        </address>
      </div>
    </div>
  </div>

  <div class="tc-site-footer__bottom">
    <div class="tc-container tc-site-footer__bottom-inner">
      <p>© 2026 Tecno Cardan. Todos los derechos reservados.</p>
      <a href="#inicio">Volver arriba <span aria-hidden="true">↑</span></a>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
