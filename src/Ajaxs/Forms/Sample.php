<?php
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
    $data = $_POST;
    if (isset($data['nonce']) && wp_verify_nonce($data['nonce'], "{$this->action}_nonce")) {
      wp_send_json(['success' => true]);
    } else {
      wp_send_json(['success' => false]);
    }
    wp_die();
  }
}