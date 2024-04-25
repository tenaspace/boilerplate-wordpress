<?php /*
$action = 'ajax_form_sample';

if (!function_exists($action)) {
  function ajax_form_sample()
  {
    $response = [
      'success' => false,
    ];

    wp_send_json($response);
    wp_die();
  }

  add_action("wp_ajax_{$action}", $action);
  add_action("wp_ajax_nopriv_{$action}", $action);
}
*/ ?>