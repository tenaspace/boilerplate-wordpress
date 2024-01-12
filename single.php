<?php get_header(); ?>

<?php get_template_part('ui/components/breadcrumb', ''); ?>

<h1>
  <?php echo get_the_title(); ?>
</h1>

<?php if (have_posts()): ?>
  <?php while (have_posts()):
    the_post(); ?>
    <div class="the-content">
      <?php the_content(); ?>
    </div>
  <?php endwhile;
  wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>