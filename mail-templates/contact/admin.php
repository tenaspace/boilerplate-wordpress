<?php

if (!function_exists('tenaspace_mail_template_contact_admin')) {
  function tenaspace_mail_template_contact_admin($data)
  {
    return '<h2>Contact information</h2>
    <ul>
      <li>' . __('Full name', 'tenaspace') . ': ' . $data['fullName'] . '</li>
      <li>' . __('E-Mail', 'tenaspace') . ': ' . $data['email'] . '</li>
      <li>' . __('Phone number', 'tenaspace') . ': ' . $data['phoneNumber'] . '</li>
      <li>' . __('Message', 'tenaspace') . ': ' . $data['message'] . '</li>
      <li>' . __('Referer', 'tenaspace') . ': ' . $data['referer'] . '</li>
    </ul>';
  }
}

?>