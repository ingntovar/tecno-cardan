<?php

$heading = is_scalar($heading ?? null) ? trim((string) $heading) : '';
$subtitle = is_scalar($subtitle ?? null) ? trim((string) $subtitle) : '';
$images = isset($images) && is_array($images) ? array_values(array_filter($images, 'is_array')) : array();
$heading_id = function_exists('wp_unique_id') ? wp_unique_id('tc-grid-title-') : 'tc-grid-title';
?>
<?php if (count($images) >= 3) : ?>
  <section class="tc-grid"<?php if ($heading !== '') : ?> aria-labelledby="<?php echo esc_attr($heading_id); ?>"<?php endif; ?>>
    <div class="tc-grid__container tc-container">
      <?php if ($heading !== '' || $subtitle !== '') : ?>
        <header class="tc-grid__header">
          <div>
            <?php if ($heading !== '') : ?>
              <h2 class="tc-grid__heading" id="<?php echo esc_attr($heading_id); ?>"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if ($subtitle !== '') : ?>
              <p class="tc-grid__subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
          </div>
        </header>
      <?php endif; ?>

      <div class="tc-grid__grid">
        <?php foreach ($images as $image) : ?>
          <?php
          $image_url = is_scalar($image['url'] ?? null) ? esc_url((string) $image['url']) : '';
          $image_alt = is_scalar($image['alt'] ?? null) ? (string) $image['alt'] : '';
          $caption = is_scalar($image['caption'] ?? null) ? (string) $image['caption'] : '';

          if ($image_url === '') {
            continue;
          }
          ?>
          <figure class="tc-grid__item">
            <img class="tc-grid__image" src="<?php echo $image_url; ?>" alt="<?php echo esc_attr($image_alt); ?>" />
            <?php if ($caption !== '') : ?>
              <figcaption class="tc-grid__caption"><?php echo esc_html($caption); ?></figcaption>
            <?php endif; ?>
          </figure>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
