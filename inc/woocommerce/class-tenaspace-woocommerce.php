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
			// add_filter('woocommerce_enqueue_styles', '__return_empty_array'); // Remove default WooCommerce CSS
			// add_action('wp_enqueue_scripts', [$this, 'scripts'], 10);
		}

		public function setup()
		{
			add_theme_support('woocommerce');
		}

		public function scripts()
		{
			/**
			 * Remove CSS
			 */
			global $wp_styles;
			foreach ($wp_styles->queue as $handle) {
				if (strpos($handle, 'wc-blocks-') === 0) {
					wp_dequeue_style($handle);
				}
			}
			wp_dequeue_style('woocommerce-inline');

			/**
			 * Add CSS & JS
			 */
			wp_enqueue_script('wc-cart-fragments');
		}
	}
}

return new Tenaspace_WooCommerce();

?>