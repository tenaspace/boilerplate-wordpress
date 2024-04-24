<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Nav_Menus
{
  use Singleton;

  protected function __construct()
  {
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    add_action('init', [$this, 'nav_menus']);
  }

  public function nav_menus()
  {
    // register_nav_menus([
    //   'sample' => __('Sample', 'ts'),
    // ]);
  }
}
?>