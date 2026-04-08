<?php

$language_attributes = get_language_attributes();
$charset = get_bloginfo('charset');
?>
<!doctype html>
<html <?php echo $language_attributes; ?>>
<head>
  <meta charset="<?php echo esc_attr($charset); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class('tc-site-shell'); ?>>
<?php wp_body_open(); ?>
<header class="tc-site-header">
  <div class="tc-container tc-site-branding">
    <div>
      <a class="tc-site-title" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
      <p class="tc-site-description"><?php bloginfo('description'); ?></p>
    </div>
  </div>
</header>
