<?php

if (!function_exists('ts_mail_template_form_contact_admin')) {
  function ts_mail_template_form_contact_admin($data)
  {
    return '<h2>Contact information</h2>
    <ul>
      <li>' . __('Full name', 'ts') . ': ' . $data['fullName'] . '</li>
      <li>' . __('E-Mail', 'ts') . ': ' . $data['email'] . '</li>
      <li>' . __('Phone number', 'ts') . ': ' . $data['phoneNumber'] . '</li>
      <li>' . __('Message', 'ts') . ': ' . $data['message'] . '</li>
      <li>' . __('Referer', 'ts') . ': ' . $data['referer'] . '</li>
    </ul>';
  }
}

?>