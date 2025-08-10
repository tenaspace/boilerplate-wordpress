// TODO
<form x-data="sampleForm($el)" novalidate>
  <div>
    <div>
      <label for="full-name">
        <?php echo app()->i18n->translate([
          'en' => 'Full name',
          'vi' => 'Họ và tên',
        ]); ?>
      </label>
      <input type="text" id="full-name" name="fullName" required class="inline-flex w-full" />
      <span x-show="errors.fullName" x-text="errors.fullName" x-cloak></span>
    </div>
    <div>
      <label for="email">
        <?php echo app()->i18n->translate([
          'en' => 'Email',
          'vi' => 'Email',
        ]); ?>
      </label>
      <input type="email" id="email" name="email" required class="inline-flex w-full" />
      <span x-show="errors.email" x-text="errors.email" x-cloak></span>
    </div>
    <div>
      <label for="telephone">
        <?php echo app()->i18n->translate([
          'en' => 'Telephone',
          'vi' => 'Số điện thoại',
        ]); ?>
      </label>
      <input type="tel" id="telephone" name="telephone" required class="inline-flex w-full" />
      <span x-show="errors.telephone" x-text="errors.telephone" x-cloak></span>
    </div>
  </div>
  <div>
    <button type="submit" class="<?php echo app()->ui->button(); ?>">
      <?php echo app()->i18n->translate([
        'en' => 'Submit',
        'vi' => 'Gửi',
      ]); ?>
    </button>
  </div>
</form>