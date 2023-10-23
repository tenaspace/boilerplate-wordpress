<?php get_header('404'); ?>

<div class="flex flex-col justify-center w-full h-screen">
  <div class="py-10">
    <div class="py-5">
      <div class="container mx-auto px-5">
        <div class="flex flex-col items-center">
          <div class="text-9xl font-bold text-center mb-2">404</div>
          <div class="text-3xl font-bold text-center mb-2">OOOps! Page Not Found</div>
          <p class="text-base md:text-lg text-center mb-10">Sorry about that! Please visit our homepage to get where you
            need to go.</p>
          <a href="<?php echo home_url(); ?>" class="inline-block text-center bg-black text-white px-5 py-2">Back to
            homepage</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer('404'); ?>