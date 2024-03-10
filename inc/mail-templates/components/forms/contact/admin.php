<?php

if (!function_exists('ts_mail_template_form_contact_admin')) {
  function ts_mail_template_form_contact_admin($data)
  {
    $template = '';
    $current_locale = get_locale();
    switch ($current_locale) {
      case 'en_US':
        $template = '<h2>Contact information</h2>
        <ul>
          <li>Full name: ' . $data['fullName'] . '</li>
          <li>E-Mail: ' . $data['email'] . '</li>
          <li>Phone number: ' . $data['phoneNumber'] . '</li>
          <li>Message: ' . $data['message'] . '</li>
        </ul>';
        break;
      case 'vi':
        $template = '<h2>Thông tin liên hệ</h2>
        <ul>
          <li>Họ và tên: ' . $data['fullName'] . '</li>
          <li>E-Mail: ' . $data['email'] . '</li>
          <li>Số điện thoại: ' . $data['phoneNumber'] . '</li>
          <li>Lời nhắn: ' . $data['message'] . '</li>
        </ul>';
        break;
      default:
        break;
    }
    return $template;
  }
}

?>