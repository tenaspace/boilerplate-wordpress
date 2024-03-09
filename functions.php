<?php

require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(get_template_directory());
$dotenv->safeLoad();

require_once('inc/classes/ts-functions.php');
$theme = wp_get_theme('ts');
$ts = (object) [
	'version' => wp_get_theme('ts'),
	'main' => require_once('inc/classes/ts.php'),
];
require_once('inc/ts-hooks.php');

$ts_functions = new Ts_Functions();

$ts_functions->require_all_files('/inc/custom-post-types');
$ts_functions->require_all_files('/mail-templates');
$ts_functions->require_all_files('/inc/shortcodes');
$ts_functions->require_all_files('/inc/ajax');

if ($ts_functions->is_woocommerce_activated()) {
	require_once('inc/classes/ts-woocommerce-functions.php');
	$ts->woocommerce = require_once('inc/classes/ts-woocommerce.php');
	$ts_functions->require_all_files('/inc/woocommerce');
}

?>