<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Init
{
  use Singleton;

  protected function __construct()
  {
    $this->set_hooks();
    $this->defines();
    Nav_Menus::instance();
    Widgets::instance();
    Fonts::instance();
    Enqueue_Scripts::instance();
    Body_Class::instance();
    Dynamic_Blocks::instance();
    Require_Folders::instance();
    Hooks::instance();
  }

  protected function set_hooks()
  {
    add_action('after_setup_theme', [$this, 'setup_theme']);
  }

  public function setup_theme()
  {
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('widgets');
  }

  private function defines()
  {
    define('PUBLIC_PATH', $this->get_public_path());
    define('PUBLIC_URI', $this->get_public_uri());
  }

  private function get_public_path()
  {
    $utils = Utils::instance();
    $path = get_template_directory() . '/dist';
    if ($utils->is_vite_dev_mode()) {
      $path = get_template_directory() . '/resources';
    }
    return $path;
  }

  private function get_public_uri()
  {
    $utils = Utils::instance();
    $uri = get_template_directory_uri() . '/dist';
    if ($utils->is_vite_dev_mode()) {
      $vite_server_port = isset($_ENV['VITE_SERVER_PORT']) && $_ENV['VITE_SERVER_PORT'] ? $_ENV['VITE_SERVER_PORT'] : 3000;
      $vite_server_origin = isset($_ENV['VITE_SERVER_ORIGIN']) && $_ENV['VITE_SERVER_ORIGIN'] ? $_ENV['VITE_SERVER_ORIGIN'] : 'http://localhost';
      $uri = $vite_server_origin . ':' . $vite_server_port . '/resources';
    }
    return $uri;
  }
}
?>