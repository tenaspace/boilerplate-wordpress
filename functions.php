<?php

require_once('vendor/autoload.php');

require_once('inc/tenaspace-functions.php');
$theme = wp_get_theme('tenaspace');
$tenaspace_version = $theme['Version'];
$tenaspace = (object) [
	'version' => $tenaspace_version,
	'main' => require_once('inc/class-tenaspace.php'),
];
require_once('inc/wordpress-shims.php');

tenaspace_require_all_files('/inc/cpts');
tenaspace_require_all_files('/inc/shortcodes');
tenaspace_require_all_files('/inc/ajax');

if (tenaspace_is_woocommerce_activated()) {
	$tenaspace->woocommerce = require_once('inc/woocommerce/class-tenaspace-woocommerce.php');
	require_once('inc/woocommerce/tenaspace-woocommerce-functions.php');
	require_once('inc/woocommerce/tenaspace-woocommerce-template-functions.php');
	require_once('inc/woocommerce/tenaspace-woocommerce-template-hooks.php');
}

?>