<?php

$action = 'form_contact';
$ajax = "wp_ajax_{$action}";
$ajax_nopriv = "wp_ajax_nopriv_{$action}";

function form_contact()
{
  $response = [
    'success' => false,
    'error' => ''
  ];
  $data = $_POST;
  if (isset($data['nonce']) && !empty($data['nonce']) && wp_verify_nonce($data['nonce'], $data['action'])) {
    $token = isset($data['token']) && !empty($data['token']) ? $data['token'] : '';
    $verify = tenaspace_recaptcha_verify($token, $data['action']);
    if ($verify['success'] == true && $verify['score'] > 0.5) {

      $admin = new \SendGrid\Mail\Mail();
      $admin->setFrom($_ENV['SENDGRID_EMAIL_SENDER'] ?? '', $_ENV['SENDGRID_EMAIL_SENDER_NAME'] ?? '');
      $admin->setSubject('');
      $admin->addTo($_ENV['EMAIL_RECIPIENTS'] ?? '');
      $admin->addContent('text/plain', '');
      $admin->addContent('text/html', '');
      $admin->setReplyTo($_ENV['EMAIL_NO_REPLY'] ?? '');
      $sendgrid_admin = new \SendGrid($_ENV['SENDGRID_API_KEY'] ?? '');

      $user = new \SendGrid\Mail\Mail();
      $user->setFrom($_ENV['SENDGRID_EMAIL_SENDER'] ?? '', $_ENV['SENDGRID_EMAIL_SENDER_NAME'] ?? '');
      $user->setSubject('');
      $user->addTo(isset($data['email']) && !empty($data['email']) && is_email($data['email']) ? $data['email'] : '');
      $user->addContent('text/plain', '');
      $user->addContent('text/html', '');
      $user->setReplyTo($_ENV['EMAIL_NO_REPLY'] ?? '');
      $sendgrid_user = new \SendGrid($_ENV['SENDGRID_API_KEY'] ?? '');

      try {
        $sendgrid_admin->send($admin);
        $sendgrid_user->send($user);
        $response['success'] = true;
      } catch (Exception $error) {
        $response['error'] = $error->getMessage();
      }
    }
  }
  wp_send_json($response);
  wp_die();
}

add_action($ajax, $action);
add_action($ajax_nopriv, $action);

?>