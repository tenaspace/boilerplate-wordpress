<?php
use TS\I18n;
use TS\Lib\Helpers;
use TS\Lib\Utils;
use TS\Main;
use TS\Ui;

if (is_readable(get_template_directory() . '/vendor/autoload.php')) {
  require_once get_template_directory() . '/vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::createImmutable(get_template_directory());
  $dotenv->safeLoad();
  function app(): stdClass
  {
    $app = new stdClass();
    $app->i18n = new I18n();
    $app->lib = new stdClass();
    $app->lib->utils = new Utils();
    $app->lib->helpers = new Helpers();
    $app->ui = new Ui();
    return $app;
  } // SETUP
  $theme = wp_get_theme('ts');
  $ts = (object) [
    'version' => $theme['Version'],
    'main' => new Main(),
  ];
} else {
  wp_die('Autoload file not found. Please run "composer install" in the theme directory. Make sure you have Composer installed and the autoload file is generated.');
}
