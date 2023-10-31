<?php

require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(get_template_directory());
$dotenv->safeLoad();

require_once('inc/tenaspace-functions.php');
$theme = wp_get_theme('tenaspace');
$tenaspace_version = $theme['Version'];
$tenaspace = (object) [
	'version' => $tenaspace_version,
	'main' => require_once('inc/class-tenaspace.php'),
];
require_once('inc/tenaspace-hooks.php');

tenaspace_require_all_files('/mail-templates', true);

tenaspace_require_all_files('/inc/custom-post-types');
tenaspace_require_all_files('/inc/shortcodes');
tenaspace_require_all_files('/inc/ajax');

if (tenaspace_is_woocommerce_activated()) {
	require_once('inc/woocommerce/tenaspace-woocommerce-functions.php');
	$tenaspace->woocommerce = require_once('inc/woocommerce/class-tenaspace-woocommerce.php');
	require_once('inc/woocommerce/tenaspace-woocommerce-template-functions.php');
	require_once('inc/woocommerce/tenaspace-woocommerce-template-hooks.php');
}

?>