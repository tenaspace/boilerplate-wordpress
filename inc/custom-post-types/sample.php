<?php /*
if (!function_exists('cptui_register_my_cpts_sample')) {
	function cptui_register_my_cpts_sample()
	{
		$labels = [
			'name' => esc_html__('Sample', 'ts'),
			'singular_name' => esc_html__('Sample', 'ts'),
		];

		$args = [
			'label' => esc_html__('Sample', 'ts'),
			'labels' => $labels,
			'description' => '',
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_rest' => true,
			'rest_base' => '',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_namespace' => 'wp/v2',
			'has_archive' => false,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'delete_with_user' => false,
			'exclude_from_search' => false,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => true,
			'can_export' => false,
			'rewrite' => ['slug' => 'sample', 'with_front' => true],
			'query_var' => true,
			'supports' => ['title', 'editor', 'thumbnail', 'author', 'page-attributes'],
			'show_in_graphql' => false,
		];

		register_post_type('sample', $args);
	}

	add_action('init', 'cptui_register_my_cpts_sample');
}
*/ ?>