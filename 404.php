<?php

$dict = DICTIONARIES['notFound'];
$ts_container = new Ts_Container();
$ts_typography = new Ts_Typography();

get_header('404');

?>

<div class="flex min-h-dvh flex-col items-center justify-center py-20 text-center"
  style="min-height: var(--ts-window-size-height);">
  <div class="<?php echo $ts_container->default(); ?>">
    <div class="flex flex-col items-center justify-center">
      <div class="<?php echo $ts_typography->h1('text-8xl'); ?>">
        404
      </div>
      <div class="<?php echo $ts_typography->h2('mt-4'); ?>">
        <?php echo $dict['title']; ?>
      </div>
      <p class="mt-2">
        <?php echo $dict['description']; ?>
      </p>
      <div class="mt-12">
        <a href="<?php echo home_url(); ?>" class="inline-flex">
          <?php get_template_part('components/button', '', [
            'as' => 'span',
            'size' => 'lg',
            'label' => $dict['backToHome'],
          ]); ?>
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer('404'); ?>