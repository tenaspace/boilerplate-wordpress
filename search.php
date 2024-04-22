<?php
use TS\Inc\Dictionaries;

$dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'pages.search']);

get_header();
?>

<?php // TODO get_template_part('components/breadcrumb', '', ['list' => [['label' => 'Sample components']]]); ?>

<div>
  <?php echo $dict('searchForKeywords'); ?>: <?php echo esc_html(get_search_query()); ?>
</div>

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