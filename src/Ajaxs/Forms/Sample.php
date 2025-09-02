<?php
namespace TS\Ajaxs\Forms;

class Sample
{
  private $action;
  private $config;
  private $response;

  public function __construct()
  {
    $this->action = 'sample_form';
    $this->config = new \stdClass();
    $this->config->send_mails = true; // SETUP
    $this->config->submissions = true; // SETUP
    $this->response = new \stdClass();
    $this->response->send_mails = false;
    $this->response->submissions = false;
    $this->hooks();
  }

  public function hooks()
  {
    add_action("wp_ajax_{$this->action}", [$this, 'ajax']);
    add_action("wp_ajax_nopriv_{$this->action}", [$this, 'ajax']);
  }

  public function ajax()
  {
    $data = $_POST;
    if (!empty($data['nonce']) && wp_verify_nonce($data['nonce'], "{$this->action}_nonce")) {
      unset($data['action']);
      unset($data['nonce']);
      $token = !empty($data['token']) ? $data['token'] : '';
      $secret_key = !empty($_ENV['CLOUDFLARE_TURNSTILE_SECRET_KEY']) ? $_ENV['CLOUDFLARE_TURNSTILE_SECRET_KEY'] : '';
      $remoteip = !empty($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
      $turnstile = new \TS\Lib\Cloudflare\Turnstile();
      $validation = $turnstile->validate($token, $secret_key, $remoteip);
      if ($validation['success']) {
        unset($data['token']);
        if ($this->config->send_mails) {
          /**
           * Send mails: admin
           */
          try {
            $mailer = app()->lib->helpers->mailer();
            $mailer->setFrom(!empty($_ENV['EMAIL_SENDER_ADDRESS']) ? $_ENV['EMAIL_SENDER_ADDRESS'] : '', !empty($_ENV['EMAIL_SENDER_NAME']) ? $_ENV['EMAIL_SENDER_NAME'] : '');
            if (!empty($_ENV['EMAIL_RECIPIENTS'])) {
              $email_recipients = explode(',', $_ENV['EMAIL_RECIPIENTS']);
              foreach ($email_recipients as $email_recipient) {
                $mailer->addAddress($email_recipient);
              }
            }
            $mailer->addReplyTo(!empty($_ENV['EMAIL_REPLY_TO']) ? $_ENV['EMAIL_REPLY_TO'] : '');
            $mailer->isHTML(true);
            $mailer->Subject = app()->i18n->translate([
              'en' => 'Sample form',
              'vi' => 'Mẫu biểu mẫu',
            ]) . ' - [#' . current_time('timestamp') . ']';
            $mail_template_admin = new \TS\MailTemplates\Forms\Sample\Admin();
            $mail_template_admin_html = $mail_template_admin->html($data);
            $mailer->Body = $mail_template_admin_html;
            $mailer->AltBody = $mail_template_admin_html;
            $mailer->send();
            $this->response->send_mails = true;
          } catch (\Exception $error) {
            app()->lib->utils->write_log($error->getMessage());
          }
          /**
           * Send mails: user
           */
          // if (!empty($data['email'])) {
          //   try {
          //     $mailer = app()->lib->helpers->mailer();
          //     $mailer->setFrom(!empty($_ENV['EMAIL_SENDER_ADDRESS']) ? $_ENV['EMAIL_SENDER_ADDRESS'] : '', !empty($_ENV['EMAIL_SENDER_NAME']) ? $_ENV['EMAIL_SENDER_NAME'] : '');
          //     $mailer->addAddress($data['email']);
          //     $mailer->addReplyTo(!empty($_ENV['EMAIL_REPLY_TO']) ? $_ENV['EMAIL_REPLY_TO'] : '');
          //     $mailer->isHTML(true);
          //     $mailer->Subject = app()->i18n->translate([
          //       'en' => 'Thank you',
          //       'vi' => 'Cảm ơn',
          //     ]);
          //     $mail_template_user = new \TS\MailTemplates\Forms\Sample\User();
          //     $mail_template_user_html = $mail_template_user->html($data);
          //     $mailer->Body = $mail_template_user_html;
          //     $mailer->AltBody = $mail_template_user_html;
          //     $mailer->send();
          //   } catch (\Exception $error) {
          //     app()->lib->utils->write_log($error->getMessage());
          //   }
          // }
        }
        if ($this->config->submissions) {
          $sheets = new \TS\Lib\Google\Apis\Sheets();
          $service = $sheets->service();
          $result = $service->spreadsheets_values->append(
            !empty($_ENV['GOOGLE_SPREADSHEETS_ID_SAMPLE_FORM']) ? $_ENV['GOOGLE_SPREADSHEETS_ID_SAMPLE_FORM'] : '',
            'Sheet1!A2',
            new \Google\Service\Sheets\ValueRange([
              'values' => [
                [...array_values($data), current_time('Y-m-d H:i:s')]
              ]
            ]),
            [
              'valueInputOption' => 'RAW'
            ]
          );
          if ($result->getUpdates()->getUpdatedCells() > 0) {
            $this->response->submissions = true;
          }
        }
        wp_send_json(['response' => ($this->response->send_mails || $this->response->submissions)]);
      } else {
        if (is_array($validation['error-codes']) && !empty($validation['error-codes'])) {
          foreach ($validation['error-codes'] as $error_code) {
            app()->lib->utils->write_log($turnstile->error_message($error_code));
          }
        }
      }
    }
    wp_send_json(['response' => false]);
    wp_die();
  }
}