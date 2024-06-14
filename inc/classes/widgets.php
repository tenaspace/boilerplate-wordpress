<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Widgets
{
  use Singleton;

  protected function __construct()
  {
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    add_action('widgets_init', [$this, 'widgets']);
  }

  public function widgets()
  {
    // register_sidebar([
    //   'name' => __('Sample', 'ts'),
    //   'id' => 'sample',
    //   'description' => __('', 'ts'),
    // ]);
  }
}
?>
