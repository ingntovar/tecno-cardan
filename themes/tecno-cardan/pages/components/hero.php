<?php

$title = isset($title) ? (string) $title : '';
$copy = isset($copy) ? (string) $copy : '';
$cta = isset($cta) && is_array($cta) ? $cta : array();
$background_image_url = isset($background_image_url) ? (string) $background_image_url : '';

$cta_title = is_string($cta['title'] ?? null) ? $cta['title'] : '';
$cta_url = is_string($cta['url'] ?? null) ? $cta['url'] : '';
$cta_href = esc_url($cta_url);
$cta_target = isset($cta['target']) && $cta['target'] === '_blank' ? '_blank' : '_self';
$cta_rel = $cta_target === '_blank' ? 'noopener noreferrer' : '';
$background_style = $background_image_url !== '' ? sprintf(' style="background-image: url(%s);"', esc_url($background_image_url)) : '';
?>
<section class="hero">
  <div class="hero__bg" aria-hidden="true"<?php echo $background_style; ?>></div>
  <div class="hero__overlay" aria-hidden="true"></div>
  <div class="hero__border hero__border--top" aria-hidden="true"></div>
  <div class="hero__border hero__border--bottom" aria-hidden="true"></div>

  <div class="hero__content">
    <div class="hero__text">
      <?php if ($title !== '') : ?>
        <h1 class="hero__title"><?php echo esc_html($title); ?></h1>
      <?php endif; ?>

      <?php if ($copy !== '') : ?>
        <p class="hero__copy"><?php echo esc_html($copy); ?></p>
      <?php endif; ?>

      <?php if ($cta_title !== '' && $cta_href !== '') : ?>
        <a
          class="hero__cta"
          href="<?php echo $cta_href; ?>"
          target="<?php echo esc_attr($cta_target); ?>"
          <?php if ($cta_rel) : ?>rel="<?php echo esc_attr($cta_rel); ?>"<?php endif; ?>
        >
          <?php echo esc_html($cta_title); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>
