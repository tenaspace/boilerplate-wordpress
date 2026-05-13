<?php
namespace TS\NavMenus;

class Main
{
  public function __construct()
  {
    $this->hooks();
  }

  protected function hooks()
  {
    add_action('init', [$this, 'register_nav_menu']);
  }

  public function register_nav_menu()
  {
    register_nav_menus([
      'main' => __('Main', 'ts'),
    ]);
  }
}