<?php get_header(); ?>

<?php tenaspace_enqueue_scripts_per_page(__FILE__); ?>

<div class="py-10">
  <div class="py-5">
    <div class="container mx-auto px-5">
      <h1 class="text-3xl font-bold">Home</h1>
    </div>
  </div>
  <?php get_template_part('ui/templates/home/intro', ''); ?>
  <?php get_template_part('ui/templates/home/contact', ''); ?>
</div>

<?php get_footer(); ?>