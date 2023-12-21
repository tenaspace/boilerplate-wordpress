<?php get_header(); ?>

<main class="py-10">
  <div class="py-5">
    <div class="container mx-auto px-5">
      <div class="mb-5">
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
      <header>
        <h1 class="text-3xl font-bold mb-2">
          <?php echo get_the_title(); ?>
        </h1>
      </header>
    </div>
  </div>
  <div class="py-5">
    <div class="container mx-auto px-5">
      <?php get_template_part('ui/components/forms/contact', ''); ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>