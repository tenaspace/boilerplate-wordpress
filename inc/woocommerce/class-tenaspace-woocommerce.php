<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('Tenaspace_WooCommerce')) {
	class Tenaspace_WooCommerce
	{
		public function __construct()
		{
			add_action('after_setup_theme', [$this, 'setup']);
			add_filter('woocommerce_enqueue_styles', '__return_empty_array'); // Remove default WooCommerce CSS
			remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
		}

		public function setup()
		{
			add_theme_support('woocommerce');
		}
	}
}

return new Tenaspace_WooCommerce();

?>