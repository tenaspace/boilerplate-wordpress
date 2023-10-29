<?php
$action = 'form_contact';
$action_url = admin_url('admin-ajax.php');
$referer = wp_get_referer();
$nonce = wp_create_nonce($action);
?>

<form novalidate class="space-y-2" x-data="formContact($el)" data-action-url="<?php echo $action_url; ?>"
  data-referer="<?php echo $referer; ?>" data-nonce="<?php echo $nonce; ?>" @submit.prevent="onSubmit">
  <div>
    <input type="text" placeholder="Full name *" class="w-full border px-5 py-2" x-model="fields.fullName"
      :class="states?.fields?.fullName?.error && 'border-red-500'" @change="onValidate" :disabled="loading" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.fullName?.error" x-text="states?.fields?.fullName?.error">
    </p>
  </div>
  <div>
    <input type="email" placeholder="E-mail *" class="w-full border px-5 py-2" x-model="fields.email"
      :class="states?.fields?.email?.error && 'border-red-500'" @change="onValidate" :disabled="loading" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.email?.error" x-text="states?.fields?.email?.error">
    </p>
  </div>
  <div>
    <input type="tel" placeholder="Telephone *" class="w-full border px-5 py-2" x-model="fields.telephone"
      :class="states?.fields?.telephone?.error && 'border-red-500'" @change="onValidate" :disabled="loading"
      x-mask="9999999999" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.telephone?.error" x-text="states?.fields?.telephone?.error">
    </p>
  </div>
  <div>
    <textarea placeholder="Message" class="w-full border px-5 py-2" x-model="fields.message"
      :disabled="loading"></textarea>
  </div>
  <div>
    <button type="submit" class="inline-block text-center bg-black text-white px-5 py-2"
      :disabled="loading">Send</button>
  </div>
  <div x-show="loading" x-cloak>loading...</div>
</form>