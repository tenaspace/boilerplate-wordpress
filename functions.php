<?php

require_once(get_template_directory() . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(get_template_directory());
$dotenv->safeLoad();

require_once(get_template_directory() . '/inc/classes/ts-functions.php');
$theme = wp_get_theme('ts');
$ts = (object) [
	'version' => $theme['Version'],
	'main' => require_once(get_template_directory() . '/inc/classes/ts.php'),
];
require_once(get_template_directory() . '/inc/ts-hooks.php');

$ts_functions = new Ts_Functions();

$ts_functions->require_all_files('/inc/custom-post-types');
$ts_functions->require_all_files('/inc/mail-templates');
$ts_functions->require_all_files('/inc/shortcodes');
$ts_functions->require_all_files('/inc/ajax');

if ($ts_functions->is_woocommerce_activated()) {
	require_once(get_template_directory() . '/inc/classes/ts-woocommerce-functions.php');
	$ts->woocommerce = require_once(get_template_directory() . '/inc/classes/ts-woocommerce.php');
	$ts_functions->require_all_files('/inc/woocommerce');
}

?>