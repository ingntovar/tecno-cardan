<?php

$content = is_scalar($content ?? null) ? trim((string) $content) : '';
?>
<?php if ($content !== '') : ?>
  <div class="tc-v2-copy">
    <?php echo wp_kses_post($content); ?>
  </div>
<?php endif; ?>
