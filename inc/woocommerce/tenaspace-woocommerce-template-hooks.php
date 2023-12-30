<?php

/**
 * content-product.php
 */

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
add_action('woocommerce_before_shop_loop_item', 'tenaspace_template_loop_product_link_open', 10);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'tenaspace_template_loop_product_thumbnail', 10);

add_action('woocommerce_shop_loop_item_title', 'tenaspace_shop_loop_item_body_start', 5);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);

add_action('woocommerce_after_shop_loop_item_title', 'tenaspace_shop_loop_item_body_end', 15);


add_filter('woocommerce_product_loop_title_classes', 'tenaspace_product_loop_title_classes');

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

?>