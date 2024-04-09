<?php if (function_exists('yoast_breadcrumb') || function_exists('woocommerce_breadcrumb')): ?>
  <div>
    <?php
    if (function_exists('yoast_breadcrumb')) {
      yoast_breadcrumb();
    } else {
      if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb();
      }
    }
    ?>
  </div>
<?php endif; ?>