<?php
namespace TS;

class Main
{
  public function __construct()
  {
    $this->hooks();
    $this->defines();
    // new \TS\PostTypes\Sample();
    // new \TS\Taxonomies\Sample();
    new CustomHooks();
    new EnqueueScripts();
    new Fonts();
    new BodyClass();
    // new \TS\NavMenus\Sample();
    // new \TS\Widgets\Sample();
    // new TinyMce();
    // new \TS\Shortcodes\Sample();
    new CustomBlocks();
    new \TS\Ajaxs\Forms\Sample();
  } // SETUP

  protected function hooks()
  {
    add_action('after_setup_theme', [$this, 'after_setup_theme']);
  }

  public function after_setup_theme()
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
    define('OPTION_PAGE_ID', pll_current_language() ? (pll_current_language() !== pll_default_language() ? 'options_page_' . pll_current_language() : 'option') : 'option');
    define('DATE_FORMAT', 'd-m-Y');
  }

  private function get_public_path()
  {
    $path = get_template_directory() . '/dist';
    if (app()->lib->helpers->is_vite_dev_mode()) {
      $path = get_template_directory() . '/resources';
    }
    return $path;
  }

  private function get_public_uri()
  {
    $uri = get_template_directory_uri() . '/dist';
    if (app()->lib->helpers->is_vite_dev_mode()) {
      $vite_server_port = !empty($_ENV['VITE_SERVER_PORT']) ? $_ENV['VITE_SERVER_PORT'] : 3000;
      $vite_server_origin = !empty($_ENV['VITE_SERVER_ORIGIN']) ? $_ENV['VITE_SERVER_ORIGIN'] : 'http://localhost';
      $uri = "{$vite_server_origin}:{$vite_server_port}/resources";
    }
    return $uri;
  }
}