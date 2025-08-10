<?php
namespace TS\Widgets;

class Sample
{
  public function __construct()
  {
    $this->hooks();
  }

  protected function hooks()
  {
    add_action('widgets_init', [$this, 'register_sidebar']);
  }

  public function register_sidebar()
  {
    register_sidebar([
      'name' => __('Sample', 'ts'),
      'id' => 'sample',
      'description' => __('', 'ts'),
    ]);
  }
}
