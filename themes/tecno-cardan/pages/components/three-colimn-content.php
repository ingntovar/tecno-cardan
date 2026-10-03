<?php

$cards = isset($cards) && is_array($cards) ? $cards : array();
$content_enabled = !empty($content_enabled);
$card_count = count($cards);
?>
<?php if (!empty($cards)) : ?>
  <section class="industrial-stats<?php echo $content_enabled ? ' industrial-stats--with-content' : ''; ?>">
    <div class="industrial-stats__container industrial-stats__container--count-<?php echo esc_attr((string) $card_count); ?>">
      <?php foreach ($cards as $card) : ?>
        <?php
        $icon_url = isset($card['icon_url']) ? (string) $card['icon_url'] : '';
        $number = isset($card['number']) ? (string) $card['number'] : '';
        $description = isset($card['description']) ? (string) $card['description'] : '';
        $title = isset($card['title']) ? (string) $card['title'] : '';
        $content = $content_enabled && isset($card['content']) ? (string) $card['content'] : '';
        $description_strong = !empty($card['description_strong']);
        ?>
        <article class="industrial-stat">
          <div class="industrial-stat__icon-slot">
            <?php if ($icon_url !== '') : ?>
              <img class="industrial-stat__icon" src="<?php echo esc_url($icon_url); ?>" alt="" aria-hidden="true" />
            <?php endif; ?>
          </div>

          <div class="industrial-stat__heading-slot">
            <?php if ($number !== '') : ?>
              <h3 class="industrial-stat__number"><?php echo esc_html($number); ?></h3>
            <?php endif; ?>

            <?php if ($title !== '') : ?>
              <h3 class="industrial-stat__title"><?php echo nl2br(esc_html($title)); ?></h3>
            <?php endif; ?>
          </div>

          <div class="industrial-stat__description-slot">
            <?php if ($description !== '') : ?>
              <p class="industrial-stat__description<?php echo $description_strong ? ' industrial-stat__description--strong' : ''; ?>"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
          </div>

          <p class="industrial-stat__content"><?php echo $content !== '' ? nl2br(esc_html($content)) : ''; ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>
