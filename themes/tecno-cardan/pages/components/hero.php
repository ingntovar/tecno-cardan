<?php

$title = isset($title) ? $title : '';
$copy = isset($copy) ? $copy : '';
$cta = isset($cta) && is_array($cta) ? $cta : array();
$background_image_url = isset($background_image_url) ? (string) $background_image_url : '';

$cta_text = isset($cta['text']) ? (string) $cta['text'] : '';
$cta_url = isset($cta['url']) ? (string) $cta['url'] : '';
$cta_is_blank = !empty($cta['is_blank']);
$cta_target = $cta_is_blank ? '_blank' : '_self';
$cta_rel = $cta_is_blank ? 'noopener noreferrer' : '';
$background_style = $background_image_url !== '' ? sprintf(' style="background-image: url(%s);"', esc_url($background_image_url)) : '';
?>
<section>
  <div class="tc-hero position-relative overflow-hidden">
    <div class="tc-hero__background position-absolute top-0 start-0 w-100 h-100"<?php echo $background_style; ?>></div>
    <div class="tc-hero__overlay position-absolute top-0 start-0 w-100 h-100"></div>

    <div class="container-fluid position-relative px-0">
      <div class="row g-0">
        <div class="col-12 col-lg-7 col-xl-6">
          <div class="tc-hero__content d-flex flex-column align-items-start justify-content-center h-100">
            <?php if ($title) : ?>
              <h1 class="tc-hero__title"><?php echo esc_html($title); ?></h1>
            <?php endif; ?>

            <?php if ($copy) : ?>
              <p class="tc-hero__copy"><?php echo esc_html($copy); ?></p>
            <?php endif; ?>

            <?php if ($cta_text && $cta_url) : ?>
              <a
                class="tc-button"
                href="<?php echo esc_url($cta_url); ?>"
                target="<?php echo esc_attr($cta_target); ?>"
                <?php if ($cta_rel) : ?>rel="<?php echo esc_attr($cta_rel); ?>"<?php endif; ?>
              >
                <?php echo esc_html($cta_text); ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
