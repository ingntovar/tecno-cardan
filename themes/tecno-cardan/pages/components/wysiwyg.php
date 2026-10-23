<?php

$content = is_scalar($content ?? null) ? trim((string) $content) : '';
?>
<?php if ($content !== '') : ?>
  <div class="tc-wysiwyg">
    <?php echo wp_kses_post($content); ?>
  </div>
<?php endif; ?>
