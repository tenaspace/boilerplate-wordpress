<?php
use TS\Inc\Dictionaries;
use TS\Inc\Utils;
use TS\Inc\UI;

$utils = Utils::instance();
$ui = UI::instance();
$dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'pages.notFound']);

get_header('404');
?>

<div class="flex min-h-[var(--ts-window-size-height)] flex-col items-center justify-center py-10 text-center lg:py-20">
  <div class="<?php echo $ui->container(); ?>">
    <div class="flex flex-col items-center justify-center">
      <div class="<?php echo $utils->cn($ui->typography('h1'), 'text-8xl font-bold'); ?>">
        404
      </div>
      <div class="<?php echo $utils->cn($ui->typography('h1'), 'mt-4'); ?>">
        <?php echo $dict('title'); ?>
      </div>
      <p class="mt-2">
        <?php echo $dict('description'); ?>
      </p>
      <div class="mt-10">
        <a href="<?php echo home_url(); ?>" class="<?php echo $ui->button(); ?>">
          <?php echo $dict('backToHome'); ?>
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer('404'); ?>