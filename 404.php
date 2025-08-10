<?php get_header('404'); ?>

<div x-data class="min-h-[var(--ts-window-size-height)]"
  :style="{ '--ts-window-size-height': $store.windowSize.height }">
  <div>
    404
  </div>
  <div>
    <?php echo app()->i18n->translate([
      'en' => 'OOOps! Page not found',
      'vi' => 'OOOps! Không tìm thấy nội dung này',
    ]); ?>
  </div>
  <p>
    <?php echo app()->i18n->translate([
      'en' => 'Sorry about that! Please visit our home page to get where you need to go.',
      'vi' => 'Xin lỗi vì sự bất tiện này! Vui lòng quay về trang chủ để tiếp tục điều hướng.',
    ]); ?>
  </p>
  <div>
    <a href="<?php echo home_url(); ?>">
      <?php echo app()->i18n->translate([
        'en' => 'Back to home page',
        'vi' => 'Quay về trang chủ',
      ]); ?>
    </a>
  </div>
</div>

<?php get_footer('404'); ?>