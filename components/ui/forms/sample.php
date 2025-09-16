<?php $action = 'sample_form'; ?>
<form novalidate x-data="sampleForm($el)"
  x-init="action = '<?php echo $action; ?>'; nonce = '<?php echo wp_create_nonce("{$action}_nonce"); ?>';"
  x-on:submit.prevent="onSubmit">
  <div>
    <div>
      <label for="full-name">
        <?php echo app()->i18n->translate([
          'en' => 'Full name',
          'vi' => 'Họ và tên',
        ]); ?>
      </label>
      <input required type="text" id="full-name" name="fullName" x-model="fields.fullName" x-bind:disabled="processing"
        x-on:input="validate" class="inline-flex w-full" />
      <p x-show="iodine?.fields?.fullName?.valid === false" x-text="iodine?.fields?.fullName?.error" x-cloak></p>
    </div>
    <div>
      <label for="email">
        <?php echo app()->i18n->translate([
          'en' => 'Email',
          'vi' => 'Email',
        ]); ?>
      </label>
      <input required type="email" id="email" name="email" x-model="fields.email" x-bind:disabled="processing"
        x-on:input="validate" class="inline-flex w-full" />
      <p x-show="iodine?.fields?.email?.valid === false" x-text="iodine?.fields?.email?.error" x-cloak></p>
    </div>
    <div>
      <label for="telephone">
        <?php echo app()->i18n->translate([
          'en' => 'Telephone',
          'vi' => 'Số điện thoại',
        ]); ?>
      </label>
      <input required type="tel" id="telephone" name="telephone" x-model="fields.telephone" x-bind:disabled="processing"
        x-on:input="validate" class="inline-flex w-full" />
      <p x-show="iodine?.fields?.telephone?.valid === false" x-text="iodine?.fields?.telephone?.error" x-cloak></p>
    </div>
    <div>
      <label for="message">
        <?php echo app()->i18n->translate([
          'en' => 'Message',
          'vi' => 'Yêu cầu',
        ]); ?>
      </label>
      <textarea id="message" name="message" x-model="fields.message" x-bind:disabled="processing" x-on:input="validate"
        class="inline-flex w-full"></textarea>
      <p x-show="iodine?.fields?.message?.valid === false" x-text="iodine?.fields?.message?.error" x-cloak></p>
    </div>
  </div>
  <div>
    <div x-ref="turnstileWidget"></div>
  </div>
  <div>
    <button type="submit" x-bind:disabled="processing || !allowSubmit" class="<?php echo app()->ui->button(); ?>">
      <?php echo app()->i18n->translate([
        'en' => 'Submit',
        'vi' => 'Gửi',
      ]); ?>
    </button>
  </div>
  <div>
    <p x-show="processing === true" x-cloak>
      <?php echo app()->i18n->translate([
        'en' => 'Processing...',
        'vi' => 'Đang xử lý...',
      ]); ?>
    </p>
    <p x-show="response === true" x-cloak>
      <?php echo app()->i18n->translate([
        'en' => 'Successfully.',
        'vi' => 'Thành công.',
      ]); ?>
    </p>
    <p x-show="response === false" x-cloak>
      <?php echo app()->i18n->translate([
        'en' => 'An error occurred.',
        'vi' => 'Đã có lỗi xảy ra.',
      ]); ?>
    </p>
  </div>
</form>