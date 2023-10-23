<?php get_header(); ?>

<div class="py-10">
  <header class="py-5">
    <div class="container mx-auto px-5">
      <div class="row md:flex-row-reverse md:items-center -m-2.5">
        <div class="col-12 md:col-auto p-2.5">
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
        <div class="col-12 md:col p-2.5">
          <h1 class="text-3xl font-bold">
            <?php echo get_the_title(); ?>
          </h1>
        </div>
      </div>
      <div class="mt-2"></div>
    </div>
  </header>
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
</div>

<?php get_footer(); ?>