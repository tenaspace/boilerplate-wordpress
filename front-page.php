<?php
use TS\Inc\UI;

$ui = UI::instance();

get_header();
?>

<?php if (have_posts()): ?>
  <?php while (have_posts()):
    the_post(); ?>
    <div class='space-y-6 p-6 lg:space-y-10 lg:p-10'>
      <h1 class='text-2xl font-extrabold tracking-tight lg:text-3xl'>boilerplate-wordpress</h1>
      
    </div>
    <?php the_content(); ?>
  <?php endwhile;
  wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>