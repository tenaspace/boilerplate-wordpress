<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<?php

$body_class = isset($args['body_class']) && is_array($args['body_class']) && sizeof($args['body_class']) > 0 ? $args['body_class'] : [];

?>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body x-data="app" @resize.window="useWindowSize" <?php body_class($body_class); ?>
  :style="{ '--ts-window-size-width': windowSize.width, '--ts-window-size-height': windowSize.height }">

  <?php wp_body_open(); ?>