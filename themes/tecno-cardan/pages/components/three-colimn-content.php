<?php

$cards = isset($cards) && is_array($cards) ? $cards : array();
?>
<?php if (!empty($cards)) : ?>
  <section class="industrial-stats">
    <div class="industrial-stats__container">
      <?php foreach ($cards as $card) : ?>
        <?php
        $icon_url = isset($card['icon_url']) ? (string) $card['icon_url'] : '';
        $number = isset($card['number']) ? (string) $card['number'] : '';
        $description = isset($card['description']) ? (string) $card['description'] : '';
        $title = isset($card['title']) ? (string) $card['title'] : '';
        $description_strong = !empty($card['description_strong']);
        ?>
        <article class="industrial-stat">
          <?php if ($icon_url !== '') : ?>
            <img class="industrial-stat__icon" src="<?php echo esc_url($icon_url); ?>" alt="" aria-hidden="true" />
          <?php endif; ?>

          <?php if ($number !== '') : ?>
            <h3 class="industrial-stat__number"><?php echo esc_html($number); ?></h3>
          <?php endif; ?>

          <?php if ($description !== '') : ?>
            <p class="industrial-stat__description<?php echo $description_strong ? ' industrial-stat__description--strong' : ''; ?>"><?php echo esc_html($description); ?></p>
          <?php endif; ?>

          <?php if ($title !== '') : ?>
            <h3 class="industrial-stat__title"><?php echo nl2br(esc_html($title)); ?></h3>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>
