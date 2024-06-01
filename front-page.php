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
      <section class='space-y-2 lg:space-y-4'>
        <h2 class='font-bold'>Common</h2>
        <div>
          <div class="<?php echo $ui->container(); ?>">Container</div>
          <div class="<?php echo $ui->typography(); ?>">Typography</div>
          <?php get_template_part('components/theme-switcher'); ?>
          <?php get_template_part('components/forms/sample'); ?>
        </div>
      </section>
      <section class='space-y-2 lg:space-y-4'>
        <h2 class='font-bold'>Components</h2>
        <?php get_template_part('components/breadcrumb', null, ['list' => [['label' => 'Sample']]]); ?>
      </section>
    </div>
    <?php the_content(); ?>
  <?php endwhile;
  wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>