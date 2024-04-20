<?php
require_once (get_template_directory() . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(get_template_directory());
$dotenv->safeLoad();
require_once get_template_directory() . '/inc/helpers/autoloader.php';
$theme = wp_get_theme('ts');
$ts = (object) [
  'version' => $theme['Version'],
  'main' => \TS\Inc\Init::instance(),
];
?>