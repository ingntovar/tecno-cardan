<?php

$home_url = home_url('/');
?>
<section>
  <article class="tc-panel">
    <p class="tc-panel__eyebrow"><?php esc_html_e('404', 'tecno-cardan'); ?></p>
    <h1 class="tc-panel__title"><?php esc_html_e('No encontramos la pagina que buscabas.', 'tecno-cardan'); ?></h1>
    <p class="tc-panel__copy"><?php esc_html_e('La estructura base del theme redirige los templates faltantes a esta vista para evitar markup duplicado.', 'tecno-cardan'); ?></p>
    <p>
      <a class="tc-button" href="<?php echo esc_url($home_url); ?>"><?php esc_html_e('Volver al inicio', 'tecno-cardan'); ?></a>
    </p>
  </article>
</section>
