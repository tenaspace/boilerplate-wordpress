<?php
use TS\Inc\Utils;

$utils = Utils::instance();

$body_class = isset($args['body_class']) && is_array($args['body_class']) && sizeof((array) $args['body_class']) > 0 ? $args['body_class'] : [];
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body x-data="providers" x-cloak @resize.window="windowSize.set" <?php body_class($body_class); ?>
  :style="{ '--ts-window-size-height': windowSize.height }">

  <?php $utils->body_open(); ?>