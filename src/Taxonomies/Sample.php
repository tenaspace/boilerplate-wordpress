<?php
namespace TS\Taxonomies;

class Sample
{
  public function __construct()
  {
    $this->hooks();
  }

  protected function hooks()
  {
    add_action('init', [$this, 'register_taxonomy']);
  }

  public function register_taxonomy()
  {
    $labels = [
      'name' => esc_html__('Sample taxonomies', 'ts'),
      'singular_name' => esc_html__('Sample taxonomy', 'ts'),
    ];
    $args = [
      'label' => esc_html__('Sample taxonomies', 'ts'),
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'hierarchical' => true, // true is category, false is tag
      'show_ui' => true,
      'show_in_menu' => true,
      'show_in_nav_menus' => true,
      'query_var' => true,
      'rewrite' => ['slug' => 'sample-taxonomy', 'with_front' => true,],
      'show_admin_column' => false,
      'show_in_rest' => true,
      'show_tagcloud' => false,
      'rest_base' => 'sample-taxonomies',
      'rest_controller_class' => 'WP_REST_Terms_Controller',
      'rest_namespace' => 'wp/v2',
      'show_in_quick_edit' => false,
      'sort' => false,
      'show_in_graphql' => false,
    ];
    register_taxonomy('sample_taxonomy', ['sample'], $args);
  }
}