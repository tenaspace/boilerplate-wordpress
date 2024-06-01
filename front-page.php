<?php
use TS\Inc\UI;

$ui = UI::instance();

get_header();
?>

<?php if (have_posts()): ?>
  <?php while (have_posts()):
    the_post(); ?>
    <div class="<?php echo $ui->container('default'); ?>">
      <?php get_template_part('components/breadcrumb', null, ['list' => [['label' => 'Sample']]]); ?>
      <div class="<?php echo $ui->typography('default'); ?>">Lorem ipsum</div>
      <?php get_template_part('components/theme-switcher'); ?>
      <?php get_template_part('components/forms/sample'); ?>
    </div>
    <?php the_content(); ?>
  <?php endwhile;
  wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>