<?php

if (!function_exists('tenaspace_wc_template_loop_product_link_open')) {
  function tenaspace_wc_template_loop_product_link_open()
  {
    global $product;

    $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

    echo '<a href="' . esc_url($link) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link block h-full">';
  }
}

?>