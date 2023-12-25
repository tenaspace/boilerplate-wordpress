<?php get_header('404'); ?>

<div class="flex h-screen w-full flex-col justify-center">
  <div class="py-6">
    <div class="container mx-auto px-6">
      <div class="flex flex-col items-center justify-center">
        <div class="mb-6 text-center text-8xl font-bold md:text-9xl">404</div>
        <div class="mb-4 text-center text-3xl font-bold md:text-4xl">OOOps! Page Not Found</div>
        <p class="mb-8 text-center">Sorry about that! Please visit our homepage to get where you
          need to go.</p>
        <a href="<?php echo home_url(); ?>"
          class="inline-block rounded-xl bg-black px-10 py-3.5 text-center font-normal text-white">Back to
          homepage</a>
      </div>
    </div>
  </div>
</div>

<?php get_footer('404'); ?>