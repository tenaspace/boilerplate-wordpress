<?php /*
if (!function_exists('cptui_register_my_taxes_sample')) {
  function cptui_register_my_taxes_sample()
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
  add_action('init', 'cptui_register_my_taxes_sample');
}
*/ ?>