<?php
namespace TS;

class EnqueueScripts
{
  private $name_main;
  private $name_constants;
  private $l10n_app;

  public function __construct()
  {
    $this->name_main = 'main';
    $this->name_constants = 'constants';
    $this->l10n_app = [
      'current_language' => \pll_current_language(),
      'adminAjaxUrl' => admin_url('admin-ajax.php'),
    ];
    $this->hooks();
  }

  protected function hooks()
  {
    add_action('wp_enqueue_scripts', [$this, 'localizes_script_app'], 99998);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 99999);
    add_action('enqueue_block_editor_assets', [$this, 'localizes_script_app'], 99998);
    add_action('enqueue_block_editor_assets', [$this, 'enqueue_scripts'], 99999);
  }

  public function enqueue_scripts()
  {
    if (app()->helpers->is_vite_dev_mode()) {
      wp_enqueue_script($this->name_main, PUBLIC_URI . '/' . $this->name_main . '.js', [], null, []);
      add_filter('script_loader_tag', function ($tag, $handle, $src) {
        if ($this->name_main === $handle) {
          $tag = '<script type="module" crossorigin id="' . $handle . '-js" src="' . $src . '"></script>';
        }
        return $tag;
      }, 10, 3);
    } else {
      $manifest_values = app()->helpers->get_manifest_values();
      if (isset($manifest_values) && is_array($manifest_values) && sizeof((array) $manifest_values) > 0) {
        foreach ($manifest_values as $manifest_value) {
          if (isset($manifest_value['css']) && is_array($manifest_value['css']) && sizeof((array) $manifest_value['css']) > 0) {
            foreach ($manifest_value['css'] as $key => $css) {
              wp_enqueue_style($this->name_main . '-' . $key, PUBLIC_URI . '/' . $css, [], null, 'all');
            }
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
    $src = '';
    if (app()->helpers->is_vite_dev_mode()) {
      $src = PUBLIC_URI . '/' . $this->name_constants . '.js';
    } else {
      $manifest = app()->helpers->get_manifest();
      if ($manifest) {
        if (isset($manifest['resources/' . $this->name_constants . '.js']['file']) && !empty($manifest['resources/' . $this->name_constants . '.js']['file'])) {
          $src = PUBLIC_URI . '/' . $manifest['resources/' . $this->name_constants . '.js']['file'];
        }
      }
    }
    wp_register_script($this->name_constants, $src, [], null);
    wp_enqueue_script($this->name_constants);
    wp_localize_script($this->name_constants, $this->name_constants, $this->l10n_app);
  }
}