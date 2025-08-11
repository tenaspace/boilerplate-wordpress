<?php $action = 'sample_form'; ?>
<form novalidate x-data="sampleForm($el)"
  x-init="fields.action = '<?php echo $action; ?>'; fields.nonce = '<?php echo wp_create_nonce("{$action}_nonce"); ?>';"
  x-on:submit.prevent="onSubmit">
  <div>
    <div>
      <label for="full-name">
        <?php echo app()->i18n->translate([
          'en' => 'Full name',
          'vi' => 'Họ và tên',
        ]); ?>
      </label>
      <input required type="text" id="full-name" name="fullName" x-model="fields.fullName"
        x-bind:disabled="isSubmitting" x-on:input="validate" class="inline-flex w-full" />
      <span x-show="errors.fullName" x-text="errors.fullName" x-cloak></span>
    </div>
    <div>
      <label for="email">
        <?php echo app()->i18n->translate([
          'en' => 'Email',
          'vi' => 'Email',
        ]); ?>
      </label>
      <input required type="email" id="email" name="email" x-model="fields.email" x-bind:disabled="isSubmitting"
        x-on:input="validate" class="inline-flex w-full" />
      <span x-show="errors.email" x-text="errors.email" x-cloak></span>
    </div>
    <div>
      <label for="telephone">
        <?php echo app()->i18n->translate([
          'en' => 'Telephone',
          'vi' => 'Số điện thoại',
        ]); ?>
      </label>
      <input required type="tel" id="telephone" name="telephone" x-model="fields.telephone"
        x-bind:disabled="isSubmitting" x-on:input="validate" class="inline-flex w-full" />
      <span x-show="errors.telephone" x-text="errors.telephone" x-cloak></span>
    </div>
    <div>
      <label for="message">
        <?php echo app()->i18n->translate([
          'en' => 'Message',
          'vi' => 'Yêu cầu',
        ]); ?>
      </label>
      <textarea id="message" name="message" x-model="fields.message" x-bind:disabled="isSubmitting"
        x-on:input="validate" class="inline-flex w-full"></textarea>
      <span x-show="errors.message" x-text="errors.message" x-cloak></span>
    </div>
  </div>
  <div>
    <button type="submit" x-bind:disabled="isSubmitting" class="<?php echo app()->ui->button(); ?>">
      <?php echo app()->i18n->translate([
        'en' => 'Submit',
        'vi' => 'Gửi',
      ]); ?>
    </button>
  </div>
</form>