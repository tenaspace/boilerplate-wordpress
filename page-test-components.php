<?php get_header(); ?>

<div class="p-10 space-y-5">
  <?php get_template_part('ui/components/breadcrumb', ''); ?>

  <h1>
    <?php echo get_the_title(); ?>
  </h1>

  <?php get_template_part('ui/components/forms/contact', ''); ?>
</div>

<?php get_footer(); ?>