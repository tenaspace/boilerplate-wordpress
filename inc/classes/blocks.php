<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Blocks
{
  use Singleton;

  protected function __construct()
  {
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    $this->blocks();
    if (version_compare(get_bloginfo('version'), '5.8', '>=')) {
      add_filter('block_categories_all', [$this, 'block_categories']);
    } else {
      add_filter('block_categories', [$this, 'block_categories']);
    }
  }

  protected function blocks()
  {
    $blocks = glob(get_template_directory() . '/blocks/*/');
    if (isset($blocks) && is_array($blocks) && sizeof((array) $blocks) > 0) {
      foreach ($blocks as $block) {
        register_block_type($block);
      }
    }
  }

  public function block_categories($block_categories)
  {
    $categories = [
      [
        'slug' => 'custom-blocks',
        'title' => 'Custom blocks'
      ]
    ];
    $block_categories = array_merge($categories, $block_categories);
    return $block_categories;
  }
}
?>
