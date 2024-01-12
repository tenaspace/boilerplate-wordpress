<?php
use TailwindMerge\TailwindMerge;

$tw = TailwindMerge::instance();

get_header('404');

?>

<div class="flex w-full h-[var(--ts-window-size-height)] flex-col justify-center">
  <div class="py-20">
    <div class="<?php echo CLASSES['container']; ?>">
      <div class="flex flex-col items-center justify-center">
        <div class="<?php echo $tw->merge([CLASSES['typography']['h1'], 'text-center text-9xl mb-4']); ?>">
          404</div>
        <div class="<?php echo $tw->merge([CLASSES['typography']['h4'], 'text-center mb-2']); ?>">OOOps! Page not
          found</div>
        <p class="text-center mb-12">Sorry about that! Please visit our home page to get where you need to go.</p>
        <a href="<?php echo home_url(); ?>"
          class="box-border inline-block rounded-lg border border-black bg-black px-6 py-2.5 text-center text-white"><span
            class="<?php echo CLASSES['typography']['small']; ?>">Back
            to
            home page</span></a>
      </div>
    </div>
  </div>
</div>

<?php get_footer('404'); ?>