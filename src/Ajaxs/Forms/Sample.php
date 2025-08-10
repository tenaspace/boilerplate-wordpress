<?php
// TODO
namespace TS\Ajaxs\Forms;

class Sample
{
  private $action;

  public function __construct()
  {
    $this->action = 'sample_form';
    $this->hooks();
  }

  public function hooks()
  {
    add_action("wp_ajax_{$this->action}", [$this, 'ajax']);
    add_action("wp_ajax_nopriv_{$this->action}", [$this, 'ajax']);
  }

  public function ajax()
  {
    $response = [
      'success' => false,
    ];

    wp_send_json($response);
    wp_die();
  }
}