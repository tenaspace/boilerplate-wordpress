<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Enqueue_Scripts
{
  use Singleton;

  private $name_main;
  private $name_app;
  private $l10n_app;

  protected function __construct()
  {
    $this->name_main = 'main';
    $this->name_app = 'app';
    $this->l10n_app = [
      'adminAjaxUrl' => admin_url('admin-ajax.php'),
    ];
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    $utils = Utils::instance();
    add_action('wp_enqueue_scripts', [$this, 'localizes_script_app'], 99998);
    if ($utils->is_vite_dev_mode()) {
      add_action('wp_head', [$this, 'scripts'], 99999);
      add_action('admin_head', [$this, 'scripts'], 99999);
    } else {
      add_action('wp_enqueue_scripts', [$this, 'scripts'], 99999);
      add_action('enqueue_block_editor_assets', [$this, 'scripts'], 99999);
    }
  }

  public function localizes_script_app()
  {
    $utils = Utils::instance();
    $src = '';
    if ($utils->is_vite_dev_mode()) {
      $src = PUBLIC_URI . '/' . $this->name_app . '.js';
    } else {
      $manifest = $utils->get_manifest();
      if ($manifest) {
        if (isset($manifest['src/' . $this->name_app . '.js']['file']) && !empty($manifest['src/' . $this->name_app . '.js']['file'])) {
          $src = PUBLIC_URI . '/' . $manifest['src/' . $this->name_app . '.js']['file'];
        }
      }
    }
    wp_register_script($this->name_app, $src, [], null);
    wp_enqueue_script($this->name_app);
    wp_localize_script($this->name_app, $this->name_app, $this->l10n_app);
  }

  public function scripts()
  {
    $utils = Utils::instance();
    if ($utils->is_vite_dev_mode()) {
      echo '<script type="module" crossorigin src="' . PUBLIC_URI . '/' . $this->name_main . '.js"></script>';
    } else {
      $manifest_values = $utils->get_manifest_values();
      if (isset($manifest_values) && is_array($manifest_values) && sizeof((array) $manifest_values) > 0) {
        foreach ($manifest_values as $manifest_value) {
          if (isset($manifest_value['css']) && is_array($manifest_value['css']) && sizeof((array) $manifest_value['css']) > 0) {
            /**
             * CSS
             */

            foreach ($manifest_value['css'] as $key => $css) {
              wp_enqueue_style($this->name_main . '-' . $key, PUBLIC_URI . '/' . $css, [], null, 'all');
            }

            /**
             * JS
             */

            if (isset($manifest_value['file']) && !empty($manifest_value['file'])) {
              wp_enqueue_script($this->name_main, PUBLIC_URI . '/' . $manifest_value['file'], [], null, ['in_footer' => true, 'strategy' => 'defer']);
            }
          }
        }
      }
    }
  }
}
?>