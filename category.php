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
          <?php echo get_the_archive_title(); ?>
        </h1>
        <?php echo get_the_archive_description(); ?>
      </header>
    </div>
  </div>
  <div class="py-5">
    <div class="container mx-auto px-5">
      <?php if (have_posts()): ?>
        <ul class="row -m-4">
          <?php while (have_posts()):
            the_post(); ?>
            <li class="col-12 p-4">
              <h2 class="text-xl font-bold mb-2">
                <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                  <?php echo get_the_title(); ?>
                </a>
              </h2>
              <p>
                <?php echo get_the_excerpt(); ?>
              </p>
            </li>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>