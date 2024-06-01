<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Body_Class
{
  use Singleton;

  protected function __construct()
  {
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    add_filter('body_class', [$this, 'body_class']);
  }

  public function body_class($classes)
  {
    $utils = Utils::instance();
    $ui = UI::instance();
    $classes = explode(' ', $utils->cn('antialiased font-be-vietnam-pro bg-white text-black', $ui->typography(), $classes));
    return $classes;
  }
}
?>