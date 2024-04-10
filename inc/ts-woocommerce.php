<?php

if (!class_exists('Ts_WooCommerce')) {
	class Ts_WooCommerce
	{
		public function __construct()
		{
			add_action('after_setup_theme', [$this, 'setup']);
			add_filter('woocommerce_enqueue_styles', '__return_empty_array'); // Remove default WooCommerce CSS
		}

		public function setup()
		{
			add_theme_support('woocommerce');
		}
	}
}

return new Ts_WooCommerce();

?>