<?php get_header(); ?>

<?php if (have_posts()): ?>
  <?php while (have_posts()):
    the_post(); ?>
    <h1 class='text-2xl font-extrabold tracking-tight lg:text-3xl'>boilerplate-wordpress</h1>
    <?php the_content(); ?>
    <?php get_template_part('components/forms/sample'); ?>
  <?php endwhile;
  wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>