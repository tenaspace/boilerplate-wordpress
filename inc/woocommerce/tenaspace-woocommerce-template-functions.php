<?php

if (!function_exists('tenaspace_woocommerce_main_content_wrapper')) {
  function tenaspace_woocommerce_main_content_wrapper()
  {
    echo '<div><div class="' . CLASSES['container'] . '">';
  }
}

if (!function_exists('tenaspace_woocommerce_main_content_wrapper_end')) {
  function tenaspace_woocommerce_main_content_wrapper_end()
  {
    echo '</div></div>';
  }
}

?>