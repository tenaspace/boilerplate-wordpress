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
  if (isset($data['nonce']) && wp_verify_nonce($data['nonce'], $data['action'])) {

    // process

    $response = [
      'success' => true,
    ];
  }
  wp_send_json($response);
  wp_die();
}
add_action($ajax, $action);
add_action($ajax_nopriv, $action);

?>