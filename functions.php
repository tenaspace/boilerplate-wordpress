<?php
use TS\Lib\Helpers;
use TS\Lib\Utils;
use TS\Lib\DateFns;
use TS\I18n;
use TS\Ui;
use TS\Main;

if (!is_readable(get_template_directory() . '/vendor/autoload.php')) {
  wp_die('Autoload file not found. Please run "composer install" in the theme directory. Make sure you have Composer installed and the autoload file is generated.');
}
require_once get_template_directory() . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(get_template_directory());
$dotenv->safeLoad();
function app(): stdClass
{
  $app = new stdClass();
  $app->utils = new Utils();
  $app->helpers = new Helpers();
  $app->date_fns = new DateFns();
  $app->i18n = new I18n();
  $app->ui = new Ui();
  return $app;
} // SETUP
$theme = wp_get_theme('ts');
$ts = (object) [
  'version' => $theme['Version'],
  'main' => new Main(),
];
