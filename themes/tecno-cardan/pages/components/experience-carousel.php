<?php

$slides = isset($slides) && is_array($slides) ? $slides : array();
$slides = array_values(array_filter($slides, 'is_array'));
$show_content = isset($show_content) && (bool) $show_content;
$slide_count = count($slides);
?>
<?php if ($slide_count > 0) : ?>
  <section
    class="experience-carousel<?php echo $show_content ? ' experience-carousel--with-content' : ''; ?>"
    data-js-experience-carousel
    role="region"
    aria-roledescription="carousel"
    aria-label="Experiencia Tecno Cardan"
  >
    <div class="experience-carousel__container tc-container">
      <div class="experience-carousel__stage" data-carousel-stage>
        <div class="swiper experience-carousel__swiper" data-carousel-swiper>
          <div class="swiper-wrapper">
            <?php foreach ($slides as $slide) : ?>
            <?php
            $media_title = is_scalar($slide['media_title'] ?? null) ? (string) $slide['media_title'] : '';
            $image_url = is_scalar($slide['image_url'] ?? null) ? (string) $slide['image_url'] : '';
            $image_src = esc_url($image_url);
            $image_alt = is_scalar($slide['image_alt'] ?? null) ? (string) $slide['image_alt'] : '';
            $title = is_scalar($slide['title'] ?? null) ? (string) $slide['title'] : '';
            $description = is_scalar($slide['description'] ?? null) ? (string) $slide['description'] : '';
            $cta = isset($slide['cta']) && is_array($slide['cta']) ? $slide['cta'] : array();
            $cta_title = is_scalar($cta['title'] ?? null) ? (string) $cta['title'] : '';
            $cta_url = is_scalar($cta['url'] ?? null) ? (string) $cta['url'] : '';
            $cta_href = esc_url($cta_url);
            $cta_target = isset($cta['target']) && $cta['target'] === '_blank' ? '_blank' : '_self';
            $cta_rel = $cta_target === '_blank' ? 'noopener noreferrer' : '';
            ?>
            <article class="swiper-slide experience-carousel__slide">
              <div class="experience-carousel__media">
                <?php if ($media_title !== '') : ?>
                  <div class="experience-carousel__media-heading">
                    <span class="experience-carousel__media-title"><?php echo esc_html($media_title); ?></span>
                  </div>
                <?php endif; ?>

                <div class="experience-carousel__media-frame<?php echo $image_src === '' ? ' experience-carousel__media-frame--placeholder' : ''; ?>">
                  <?php if ($image_src !== '') : ?>
                    <img
                      class="experience-carousel__image"
                      src="<?php echo $image_src; ?>"
                      alt="<?php echo esc_attr($image_alt); ?>"
                    />
                  <?php else : ?>
                    <span class="experience-carousel__placeholder-label">Imagen del proyecto</span>
                  <?php endif; ?>

                </div>
              </div>

              <?php if ($show_content) : ?>
                <div class="experience-carousel__content">
                  <?php if ($title !== '') : ?>
                    <h2 class="experience-carousel__title"><?php echo esc_html($title); ?></h2>
                  <?php endif; ?>

                  <?php if ($description !== '') : ?>
                    <p class="experience-carousel__description"><?php echo nl2br(esc_html($description)); ?></p>
                  <?php endif; ?>

                  <?php if ($cta_title !== '' && $cta_href !== '') : ?>
                    <a
                      class="experience-carousel__cta"
                      href="<?php echo $cta_href; ?>"
                      target="<?php echo esc_attr($cta_target); ?>"
                      <?php if ($cta_rel !== '') : ?>rel="<?php echo esc_attr($cta_rel); ?>"<?php endif; ?>
                    >
                      <span><?php echo esc_html($cta_title); ?></span>
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M9 5L16 12L9 19" />
                      </svg>
                    </a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </article>
            <?php endforeach; ?>
          </div>

          <?php if ($slide_count > 1) : ?>
            <div class="experience-carousel__pagination" data-carousel-pagination></div>
          <?php endif; ?>
        </div>

        <?php if ($slide_count > 1) : ?>
          <div class="experience-carousel__controls" data-carousel-controls>
            <button
              class="experience-carousel__nav experience-carousel__nav--prev"
              type="button"
              data-carousel-prev
              aria-label="Mostrar slide anterior"
            >
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M15 5L8 12L15 19" />
              </svg>
            </button>
            <button
              class="experience-carousel__nav experience-carousel__nav--next"
              type="button"
              data-carousel-next
              aria-label="Mostrar slide siguiente"
            >
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M9 5L16 12L9 19" />
              </svg>
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
