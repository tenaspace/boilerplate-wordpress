<?php get_header(); ?>

<?php get_template_part('components/breadcrumb'); ?>

<h1>
  <?php echo get_the_archive_title(); ?>
</h1>

<?php echo get_the_archive_description(); ?>

<?php if (have_posts()): ?>
  <?php while (have_posts()):
    the_post(); ?>
    <h2>
      <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
        <?php echo get_the_title(); ?>
      </a>
    </h2>
    <p>
      <?php echo get_the_excerpt(); ?>
    </p>
  <?php endwhile;
  wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>