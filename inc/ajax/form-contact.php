<?php

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
      $response['success'] = true;
    }
  }
  wp_send_json($response);
  wp_die();
}

add_action($ajax, $action);
add_action($ajax_nopriv, $action);

?>