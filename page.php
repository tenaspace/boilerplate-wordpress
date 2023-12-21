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
      <?php if (have_posts()): ?>
        <div>
          <?php while (have_posts()):
            the_post(); ?>
            <div>
              <?php the_content(); ?>
            </div>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>