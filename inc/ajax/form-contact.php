<?php

$action = 'form_contact';
$ajax = "wp_ajax_{$action}";
$ajax_nopriv = "wp_ajax_nopriv_{$action}";

function form_contact()
{
  $res = [
    'success' => false,
    'alert' => [
      'type' => 'error',
      'name' => 'Error',
      'message' => '',
    ],
  ];
  $data = $_POST;
  if (isset($data['nonce']) && wp_verify_nonce($data['nonce'], $data['action'])) {

    // process

    $res = [
      'success' => true,
      'alert' => [
        'type' => 'success',
        'name' => 'Successfully',
        'message' => '',
      ],
    ];
  }
  wp_send_json($res);
  wp_die();
}
add_action($ajax, $action);
add_action($ajax_nopriv, $action);

?>