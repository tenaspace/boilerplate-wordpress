<?php

/**
 * content-product.php
 */

if (!function_exists('tenaspace_template_loop_product_link_open')) {
  function tenaspace_template_loop_product_link_open()
  {
    global $product;

    $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

    echo '<a href="' . esc_url($link) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link block border border-ts-beige rounded-xl overflow-hidden h-full">';
  }
}

if (!function_exists('tenaspace_template_loop_product_thumbnail')) {
  function tenaspace_template_loop_product_thumbnail()
  {
    echo '<div class="flex justify-center bg-ts-beige px-6 py-5">';
    echo woocommerce_get_product_thumbnail();
    echo '</div>';
  }
}

if (!function_exists('tenaspace_shop_loop_item_body_start')) {
  function tenaspace_shop_loop_item_body_start()
  {
    echo '<div class="p-3.5">';
  }
}

if (!function_exists('tenaspace_shop_loop_item_body_end')) {
  function tenaspace_shop_loop_item_body_end()
  {
    echo '</div>';
  }
}

if (!function_exists('tenaspace_product_loop_title_classes')) {
  function tenaspace_product_loop_title_classes($classes)
  {
    $classes .= ' font-medium text-ts-gray';
    return $classes;
  }
}

?>