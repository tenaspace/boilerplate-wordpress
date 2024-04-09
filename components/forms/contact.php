<?php

$action = 'form_contact';
$nonce = wp_create_nonce($action);

$dict = DICTIONARIES['components']['forms']['contact'];

?>

<form novalidate x-data="formContact($el)" data-action="<?php echo $action; ?>" data-nonce="<?php echo $nonce; ?>"
  @submit.prevent="onSubmit">
  <div>
    <input type="text" placeholder="<?php echo $dict['inputs']['fullName']['label']; ?> *"
      class="w-full border border-black bg-transparent outline-none placeholder:text-gray-400 focus:border focus:border-blue-500 dark:border-white dark:placeholder:text-gray-500 dark:focus:border-blue-500"
      x-model="fields.fullName" :class="states?.fields?.fullName?.error && 'border-red-500'" @change="onValidate"
      @keyup="onValidate" :disabled="loading" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.fullName?.error" x-text="states?.fields?.fullName?.error">
    </p>
  </div>
  <div>
    <input type="email" placeholder="<?php echo $dict['inputs']['email']['label']; ?> *"
      class="w-full border border-black bg-transparent outline-none placeholder:text-gray-400 focus:border focus:border-blue-500 dark:border-white dark:placeholder:text-gray-500 dark:focus:border-blue-500"
      x-model="fields.email" :class="states?.fields?.email?.error && 'border-red-500'" @change="onValidate"
      @keyup="onValidate" :disabled="loading" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.email?.error" x-text="states?.fields?.email?.error">
    </p>
  </div>
  <div>
    <input type="tel" placeholder="<?php echo $dict['inputs']['phoneNumber']['label']; ?> *"
      class="w-full border border-black bg-transparent outline-none placeholder:text-gray-400 focus:border focus:border-blue-500 dark:border-white dark:placeholder:text-gray-500 dark:focus:border-blue-500"
      x-model="fields.phoneNumber" :class="states?.fields?.phoneNumber?.error && 'border-red-500'" @change="onValidate"
      @keyup="onValidate" :disabled="loading" x-mask="9999999999" />
    <p class="text-red-500" x-cloak x-show="states?.fields?.phoneNumber?.error"
      x-text="states?.fields?.phoneNumber?.error">
    </p>
  </div>
  <div>
    <textarea placeholder="<?php echo $dict['inputs']['message']['label']; ?>"
      class="w-full border border-black bg-transparent outline-none placeholder:text-gray-400 focus:border focus:border-blue-500 dark:border-white dark:placeholder:text-gray-500 dark:focus:border-blue-500"
      x-model="fields.message" :disabled="loading"></textarea>
  </div>
  <div>
    <button type="submit" :disabled="loading">
      <?php echo $dict['submit']['label']; ?>
    </button>
  </div>
  <div x-show="loading" x-cloak>
    <?php echo $dict['pending'] . '...'; ?>
  </div>
</form>