<?php
use PHPMailer\PHPMailer\Exception;

$action = 'form_contact';
$ajax = "wp_ajax_{$action}";
$ajax_nopriv = "wp_ajax_nopriv_{$action}";

function form_contact()
{
  $response = [
    'success' => false,
  ];
  $data = $_POST;
  if (isset($data['nonce']) && !empty($data['nonce']) && wp_verify_nonce($data['nonce'], $data['action'])) {
    $token = isset($data['token']) && !empty($data['token']) ? $data['token'] : '';
    $verify = tenaspace_recaptcha_verify($token, $data['action']);
    if ($verify['success'] == true && $verify['score'] > 0.5) {
      unset($data['token']);

      $mail = tenaspace_mailer();

      // Send to Admin
      try {
        $mail->setFrom($_ENV['EMAIL_SENDER'] ?? '', $_ENV['EMAIL_SENDER_NAME'] ?? '');
        if ($_ENV['EMAIL_RECIPIENTS']) {
          $recipients = explode(',', $_ENV['EMAIL_RECIPIENTS']);
          if (isset($recipients) && is_array($recipients) && sizeof($recipients) > 0) {
            foreach ($recipients as $recipient) {
              $mail->addAddress($recipient);
            }
          }
        }
        $mail->isHTML(true);
        $mail->Subject = '[#' . current_time('timestamp') . '] ' . __('Contact request', 'tenaspace');
        $mail->Body = tenaspace_mail_template_contact_admin($data);
        $mail->addReplyTo($_ENV['EMAIL_NO_REPLY'] ?? '');
        $mail->send();

        $response['success'] = true;
      } catch (Exception $error) {
        tenaspace_write_log($mail->ErrorInfo);
      }
      $mail->clearAllRecipients();
      $mail->clearReplyTos();
      $mail->clearAttachments();

      // Send to User
      try {
        $mail->setFrom($_ENV['EMAIL_SENDER'] ?? '', $_ENV['EMAIL_SENDER_NAME'] ?? '');
        $mail->addAddress(isset($data['email']) && !empty($data['email']) && is_email($data['email']) ? $data['email'] : '');
        $mail->isHTML(true);
        $mail->Subject = '[#' . current_time('timestamp') . '] ' . __('Thank you for contacting us', 'tenaspace');
        $mail->Body = tenaspace_mail_template_contact_user();
        $mail->addReplyTo($_ENV['EMAIL_NO_REPLY'] ?? '');
        $mail->send();
      } catch (Exception $error) {
        tenaspace_write_log($mail->ErrorInfo);
      }
      $mail->clearAllRecipients();
      $mail->clearReplyTos();
      $mail->clearAttachments();
    } else {
      tenaspace_write_log($verify['error-codes']);
    }
  } else {
    tenaspace_write_log(__('Nonce is invalid', 'tenaspace'));
  }
  wp_send_json($response);
  wp_die();
}

add_action($ajax, $action);
add_action($ajax_nopriv, $action);

?>