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
    add_action('wp_enqueue_scripts', [$this, 'localizes_script_app'], 99998);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 99999);
    add_action('enqueue_block_editor_assets', [$this, 'localizes_script_app'], 99998);
    add_action('enqueue_block_editor_assets', [$this, 'enqueue_scripts'], 99999);
  }

  public function enqueue_scripts()
  {
    $utils = Utils::instance();
    if ($utils->is_vite_dev_mode()) {
      wp_enqueue_script($this->name_main, PUBLIC_URI . '/' . $this->name_main . '.js', [], null, []);
      add_filter('script_loader_tag', function ($tag, $handle, $src) {
        if ($this->name_main === $handle) {
          $tag = '<script type="module" crossorigin id="' . $handle . '-js" src="' . $src . '"></script>';
        }
        return $tag;
      }, 10, 3);
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

  public function localizes_script_app()
  {
    $utils = Utils::instance();
    $src = '';
    if ($utils->is_vite_dev_mode()) {
      $src = PUBLIC_URI . '/' . $this->name_app . '.js';
    } else {
      $manifest = $utils->get_manifest();
      if ($manifest) {
        if (isset($manifest['resources/' . $this->name_app . '.js']['file']) && !empty($manifest['resources/' . $this->name_app . '.js']['file'])) {
          $src = PUBLIC_URI . '/' . $manifest['resources/' . $this->name_app . '.js']['file'];
        }
      }
    }
    wp_register_script($this->name_app, $src, [], null);
    wp_enqueue_script($this->name_app);
    wp_localize_script($this->name_app, $this->name_app, $this->l10n_app);
  }
}
?>