<?php

add_action('woocommerce_before_main_content', 'tenaspace_woocommerce_main_content_wrapper', 0);
add_action('woocommerce_after_main_content', 'tenaspace_woocommerce_main_content_wrapper_end', 100);

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

?>