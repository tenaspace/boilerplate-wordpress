<?php

use TailwindMerge\TailwindMerge;

$tw = TailwindMerge::instance();

get_header('404');

?>

<div class="flex w-full h-[var(--ts-window-size-height)] flex-col justify-center">
  <div class="py-20">
    <div class="<?php echo CLASSES['container']; ?>">
      <div class="flex flex-col items-center justify-center">
        <div
          class="<?php echo $tw->merge([CLASSES['typography']['h1'], 'text-center font-extrabold text-8xl md:text-9xl lg:text-9xl mb-4']); ?>">
          404</div>
        <div class="<?php echo $tw->merge([CLASSES['typography']['h4'], 'text-center font-bold mb-2']); ?>">OOOps! Page not
          found</div>
        <p class="text-center mb-12">Sorry about that! Please visit our home page to get where you need to go.</p>
        <a href="<?php echo home_url(); ?>"
          class="<?php echo $tw->merge([CLASSES['typography']['button'], 'box-border inline-block rounded-lg border border-ts-black bg-ts-black px-7 py-4 text-center text-white']); ?>">Back
          to
          home page</a>
      </div>
    </div>
  </div>
</div>

<?php get_footer('404'); ?>