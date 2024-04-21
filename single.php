<?php get_header(); ?>

<?php // TODO get_template_part('components/breadcrumb', '', ['list' => [['label' => 'Sample components']]]); ?>

<h1>
  <?php echo get_the_title(); ?>
</h1>

<?php if (have_posts()): ?>
  <?php while (have_posts()):
    the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile;
  wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>