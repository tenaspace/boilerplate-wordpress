<?php
$body_class = isset($args['body_class']) && is_array($args['body_class']) && !empty($args['body_class']) ? $args['body_class'] : [];
?>
<!DOCTYPE html>
<html class="no-js scroll-smooth" <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class($body_class); ?> style="--font-sans: 'Manrope', sans-serif;">

  <?php app()->lib->helpers->body_open(); ?>

  <div id="site-wrapper">

  <header id="site-header" class="site-header"></header>

  <main id="site-content" class="site-content">