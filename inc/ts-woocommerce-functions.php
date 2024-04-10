<?php

if (!class_exists('Ts_WooCommerce_Functions')) {
	class Ts_WooCommerce_Functions
	{
		/**
		 * Check is product archive
		 */

		public function is_product_archive()
		{
			return(is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) ? true : false;
		}
	}
}

?>