<?php

$action_url = admin_url('admin-ajax.php');
$action = 'form_contact';
$nonce = wp_create_nonce($action);
$referer = wp_get_referer();

?>

<form novalidate class="space-y-2" x-data="formContact($el)" data-action-url="<?php echo $action_url; ?>"
  data-action="<?php echo $action; ?>" data-nonce="<?php echo $nonce; ?>" data-referer="<?php echo $referer; ?>"
  @submit.prevent="onSubmit">
  <div>
    <input type="text" placeholder="<?php echo __('Full name', 'tenaspace'); ?> *" class="w-full border px-5 py-2"
      x-model="fields.fullName" :class="states?.fields?.fullName?.error && 'border-red-500'" @keyup="onValidate"
      :disabled="loading" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.fullName?.error" x-text="states?.fields?.fullName?.error">
    </p>
  </div>
  <div>
    <input type="email" placeholder="<?php echo __('E-mail', 'tenaspace'); ?> *" class="w-full border px-5 py-2"
      x-model="fields.email" :class="states?.fields?.email?.error && 'border-red-500'" @keyup="onValidate"
      :disabled="loading" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.email?.error" x-text="states?.fields?.email?.error">
    </p>
  </div>
  <div>
    <input type="tel" placeholder="<?php echo __('Phone number', 'tenaspace'); ?> *" class="w-full border px-5 py-2"
      x-model="fields.phoneNumber" :class="states?.fields?.phoneNumber?.error && 'border-red-500'" @keyup="onValidate"
      :disabled="loading" x-mask="9999999999" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.phoneNumber?.error"
      x-text="states?.fields?.phoneNumber?.error">
    </p>
  </div>
  <div>
    <textarea placeholder="<?php echo __('Message', 'tenaspace'); ?>" class="w-full border px-5 py-2 min-h-[120px]"
      x-model="fields.message" :disabled="loading"></textarea>
  </div>
  <div>
    <button type="submit" class="inline-block text-center bg-black text-white px-5 py-2" :disabled="loading">
      <?php echo __('Submit', 'tenaspace'); ?>
    </button>
  </div>
  <div x-show="loading" x-cloak>
    <?php echo __('Loading', 'tenaspace') . '...'; ?>
  </div>
</form>