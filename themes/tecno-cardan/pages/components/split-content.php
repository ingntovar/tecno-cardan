<?php

$image_url = isset($image_url) ? (string) $image_url : '';
$image_alt = isset($image_alt) ? (string) $image_alt : '';
$image_on_right = isset($image_on_right) ? (bool) $image_on_right : false;
$logo_url = isset($logo_url) ? (string) $logo_url : '';
$title_prefix = isset($title_prefix) ? (string) $title_prefix : '';
$title_highlight = isset($title_highlight) ? (string) $title_highlight : '';
$title_suffix = isset($title_suffix) ? (string) $title_suffix : '';
$description = isset($description) ? (string) $description : '';
$cta = isset($cta) && is_array($cta) ? $cta : array();
$cta_title = is_scalar($cta['title'] ?? null) ? (string) $cta['title'] : '';
$cta_url = is_scalar($cta['url'] ?? null) ? (string) $cta['url'] : '';
$cta_href = esc_url($cta_url);
$cta_target = isset($cta['target']) && $cta['target'] === '_blank' ? '_blank' : '_self';
$cta_rel = $cta_target === '_blank' ? 'noopener noreferrer' : '';
?>
<section class="service-feature<?php echo $image_on_right ? ' service-feature--image-right' : ''; ?>">
  <div class="service-feature__media">
    <img
      src="<?php echo esc_url($image_url); ?>"
      alt="<?php echo esc_attr($image_alt); ?>"
      class="service-feature__image"
    />
  </div>

  <div class="service-feature__content">
    <div class="service-feature__inner">
      <div class="service-feature__header">
        <?php if ($logo_url !== '') : ?>
          <div class="service-feature__logo">
            <img
              src="<?php echo esc_url($logo_url); ?>"
              alt=""
              class="service-feature__logo-image"
              aria-hidden="true"
            />
          </div>
        <?php endif; ?>

        <h2 class="service-feature__title">
          <?php echo esc_html($title_prefix); ?><?php if ($title_highlight !== '') : ?> <span><?php echo esc_html($title_highlight); ?></span><?php endif; ?><?php if ($title_suffix !== '') : ?>
            <br />
            <?php echo esc_html($title_suffix); ?><?php endif; ?>
        </h2>
      </div>

      <p class="service-feature__description"><?php echo wp_kses($description, array('strong' => array())); ?></p>

      <?php if ($cta_title !== '' && $cta_href !== '') : ?>
        <a
          href="<?php echo $cta_href; ?>"
          class="service-feature__cta"
          target="<?php echo esc_attr($cta_target); ?>"
          <?php if ($cta_rel !== '') : ?>rel="<?php echo esc_attr($cta_rel); ?>"<?php endif; ?>
        >
          <span><?php echo esc_html($cta_title); ?></span>
          <svg
            class="service-feature__arrow"
            width="22"
            height="22"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            <path
              d="M9 5L16 12L9 19"
              stroke="currentColor"
              stroke-width="2.5"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>
