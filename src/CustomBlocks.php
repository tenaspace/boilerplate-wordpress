<?php
namespace TS;

class CustomBlocks
{
  public function __construct()
  {
    $this->hooks();
  }

  protected function hooks()
  {
    $this->custom_blocks();
    if (version_compare(get_bloginfo('version'), '5.8', '>=')) {
      add_filter('block_categories_all', [$this, 'block_categories']);
    } else {
      add_filter('block_categories', [$this, 'block_categories']);
    }
  }

  public function custom_blocks()
  {
    $custom_blocks = glob(get_template_directory() . '/custom-blocks/*/');
    if (is_array($custom_blocks) && !empty($custom_blocks)) {
      foreach ($custom_blocks as $block) {
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