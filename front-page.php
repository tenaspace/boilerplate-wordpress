<?php
use TS\Inc\UI;

$ui = UI::instance();

get_header();
?>

<?php if (have_posts()): ?>
  <?php while (have_posts()):
    the_post(); ?>
    <div>
      <div class="<?php echo $ui->container('default'); ?>">
        <?php get_template_part('components/breadcrumb', null, ['list' => [['label' => 'Sample']]]); ?>
      </div>
    </div>
    <div>
      <div class="<?php echo $ui->container('default'); ?>">
        <h1 class="<?php echo $ui->typography('h1'); ?>">Lorem ipsum</h1>
        <h2 class="<?php echo $ui->typography('h2'); ?>">Lorem ipsum</h2>
        <h3 class="<?php echo $ui->typography('h3'); ?>">Lorem ipsum</h3>
        <h4 class="<?php echo $ui->typography('h4'); ?>">Lorem ipsum</h4>
        <p class="<?php echo $ui->typography('lead'); ?>">Lorem ipsum</p>
        <p class="<?php echo $ui->typography('large'); ?>">Lorem ipsum</p>
        <p class="<?php echo $ui->typography('default'); ?>">Lorem ipsum</p>
        <p class="<?php echo $ui->typography('small'); ?>">Lorem ipsum</p>
        <blockquote class="<?php echo $ui->typography('blockquote'); ?>">Lorem ipsum</blockquote>
        <p>
          <code class="<?php echo $ui->typography('inline-code'); ?>">Lorem ipsum</code>
        </p>
      </div>
    </div>
    <div>
      <div class="<?php echo $ui->container('default'); ?>">
        <?php get_template_part('components/theme-switcher'); ?>
      </div>
    </div>
    <div>
      <div class="<?php echo $ui->container('default'); ?>">
        <div class='max-w-lg'>
          <?php get_template_part('components/forms/sample'); ?>
        </div>
      </div>
    </div>
    <?php the_content(); ?>
  <?php endwhile;
  wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>