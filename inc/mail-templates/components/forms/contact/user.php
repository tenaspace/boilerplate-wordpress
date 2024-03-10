<?php

if (!function_exists('ts_mail_template_form_contact_user')) {
  function ts_mail_template_form_contact_user()
  {
    $template = '';
    $current_locale = get_locale();
    switch ($current_locale) {
      case 'en_US':
        $template = '<p>Thank you.</p>';
        break;
      case 'vi':
        $template = '<p>Cảm ơn.</p>';
        break;
      default:
        break;
    }
    return $template;
  }
}

?>