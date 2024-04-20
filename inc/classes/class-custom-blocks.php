<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Custom_Blocks
{
  use Singleton;

  protected function __construct()
  {
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    $this->custom_blocks();
    if (version_compare(get_bloginfo('version'), '5.8', '>=')) {
      add_filter('block_categories_all', [$this, 'custom_block_categories']);
    } else {
      add_filter('block_categories', [$this, 'custom_block_categories']);
    }
  }

  protected function custom_blocks()
  {
    $blocks = glob(get_template_directory() . '/custom-blocks/*/');
    if (isset($blocks) && is_array($blocks) && sizeof((array) $blocks) > 0) {
      foreach ($blocks as $block) {
        register_block_type($block);
      }
    }
  }

  public function custom_block_categories($categories)
  {
    $categories[] = [
      'slug' => 'custom-blocks',
      'title' => 'Custom blocks'
    ];
    return $categories;
  }
}
?>