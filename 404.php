<?php
use TS\Inc\Dictionaries;

$dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'pages.notFound']);

get_header('404');
?>

<div x-data class="min-h-[var(--ts-window-size-height)]"
  :style="{ '--ts-window-size-height': $store.windowSize.height }">
  <div>
    404
  </div>
  <div>
    <?php echo $dict('title'); ?>
  </div>
  <p>
    <?php echo $dict('description'); ?>
  </p>
  <div>
    <a href="<?php echo home_url(); ?>">
      <?php echo $dict('backToHome'); ?>
    </a>
  </div>
</div>

<?php get_footer('404'); ?>