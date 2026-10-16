<?php

$eyebrow = is_scalar($eyebrow ?? null) ? trim((string) $eyebrow) : '';
$heading = is_scalar($heading ?? null) ? trim((string) $heading) : '';
$intro = is_scalar($intro ?? null) ? trim((string) $intro) : '';
$products = isset($products) && is_array($products) ? array_values(array_filter($products, 'is_array')) : array();

?>
<?php if (!empty($products)) : ?>
  <section class="featured-products"<?php if ($heading !== '') : ?> aria-labelledby="featured-products-heading"<?php endif; ?>>
    <div class="featured-products__container">
      <?php if ($eyebrow !== '' || $heading !== '' || $intro !== '') : ?>
        <header class="featured-products__header">
          <?php if ($eyebrow !== '') : ?>
            <span class="featured-products__eyebrow"><?php echo esc_html($eyebrow); ?></span>
          <?php endif; ?>
          <?php if ($heading !== '') : ?>
            <h2 class="featured-products__heading" id="featured-products-heading"><?php echo esc_html($heading); ?></h2>
          <?php endif; ?>
          <div class="featured-products__line" aria-hidden="true"></div>
          <?php if ($intro !== '') : ?>
            <p class="featured-products__intro"><?php echo nl2br(esc_html($intro)); ?></p>
          <?php endif; ?>
        </header>
      <?php endif; ?>

      <div class="featured-products__grid">
        <?php foreach ($products as $product) : ?>
          <?php
          $image_url = is_scalar($product['image_url'] ?? null) ? esc_url((string) $product['image_url']) : '';
          $image_alt = is_scalar($product['image_alt'] ?? null) ? (string) $product['image_alt'] : '';
          $badge = is_scalar($product['badge'] ?? null) ? trim((string) $product['badge']) : '';
          $title = is_scalar($product['title'] ?? null) ? trim((string) $product['title']) : '';
          $description = is_scalar($product['description'] ?? null) ? trim((string) $product['description']) : '';
          $cta = isset($product['cta']) && is_array($product['cta']) ? $product['cta'] : array();
          $cta_title = is_scalar($cta['title'] ?? null) ? trim((string) $cta['title']) : '';
          $cta_url = is_scalar($cta['url'] ?? null) ? esc_url((string) $cta['url']) : '';
          $cta_target = ($cta['target'] ?? '') === '_blank' ? '_blank' : '_self';
          $cta_rel = $cta_target === '_blank' ? 'noopener noreferrer' : '';

          if ($image_url === '' || $title === '') {
            continue;
          }
          ?>
          <article class="featured-products__card">
            <div class="featured-products__media">
              <img class="featured-products__image" src="<?php echo $image_url; ?>" alt="<?php echo esc_attr($image_alt); ?>" />
              <?php if ($badge !== '') : ?>
                <span class="featured-products__badge"><?php echo esc_html($badge); ?></span>
              <?php endif; ?>
            </div>
            <div class="featured-products__content">
              <h3 class="featured-products__title"><?php echo esc_html($title); ?></h3>
              <?php if ($description !== '') : ?>
                <p class="featured-products__description"><?php echo nl2br(esc_html($description)); ?></p>
              <?php endif; ?>
              <?php if ($cta_title !== '' && $cta_url !== '') : ?>
                <a class="featured-products__cta" href="<?php echo $cta_url; ?>" target="<?php echo esc_attr($cta_target); ?>"<?php if ($cta_rel !== '') : ?> rel="<?php echo esc_attr($cta_rel); ?>"<?php endif; ?>>
                  <span><?php echo esc_html($cta_title); ?></span>
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                </a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
