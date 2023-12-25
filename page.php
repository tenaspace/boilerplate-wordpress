<?php get_header(); ?>

<?php get_template_part('ui/components/breadcrumb', ''); ?>

<h1>
  <?php echo get_the_title(); ?>
</h1>

<?php if (have_posts()): ?>
  <div>
    <div>
      <?php while (have_posts()):
        the_post(); ?>
        <div>
          <?php the_content(); ?>
        </div>
      <?php endwhile;
      wp_reset_postdata(); ?>
    </div>
  </div>
<?php endif; ?>

<?php get_footer(); ?>