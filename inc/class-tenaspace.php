<?php

if (!defined('ABSPATH')) {
  exit;
}

use TailwindMerge\TailwindMerge;

if (!class_exists('Tenaspace')) {
  class Tenaspace
  {
    public function __construct()
    {
      add_action('after_setup_theme', [$this, 'setup']);
      $this->defines();
      $this->google_fonts();
      add_action('init', [$this, 'localizes_scripts']);
      $this->scripts();
      add_filter('body_class', [$this, 'body_classes']);
      add_action('widgets_init', [$this, 'widgets']);
      add_action('init', [$this, 'custom_blocks']);
    }

    public function setup()
    {
      add_theme_support('title-tag');
      load_theme_textdomain('tenaspace', get_template_directory() . '/languages');
      add_theme_support('automatic-feed-links');
      add_theme_support('post-thumbnails');
      register_nav_menus([
        'primary' => __('primary', 'tenaspace'),
      ]);
      add_theme_support('widgets');
    }

    public function defines()
    {
      $public_path = get_template_directory() . '/dist';
      $public_uri = get_template_directory_uri() . '/dist';

      if (tenaspace_is_vite_dev_mode()) {
        $vite_server_port = $_ENV['VITE_SERVER_PORT'] ?? 3000;
        $public_path = get_template_directory() . '/src';
        $public_uri = 'http://localhost:' . $vite_server_port . '/src';
      }

      define('PUBLIC_PATH', $public_path);
      define('PUBLIC_URI', $public_uri);

      define('CLASSES', [
        'container' => 'mx-auto w-full px-4 sm:px-10 md:px-0 md:w-[88.88888%] md:max-w-[1280px]',
        'typography' => [
          'h1' => 'text-[56px] leading-[64px] font-bold',
          'h2' => 'text-[48px] leading-[56px] font-bold',
          'h3' => 'text-[40px] leading-[48px] font-bold',
          'h4' => 'text-[32px] leading-[40px] font-bold',
          'h5' => 'text-[24px] leading-[32px] font-bold',
          'h6' => 'text-[20px] leading-[26px] font-bold',
          'large' => 'text-[18px] leading-[24px] font-medium',
          'base' => 'text-[16px] leading-[24px] font-normal',
          'small' => 'text-[14px] leading-[24px] font-normal',
          'extra-small' => 'text-[12px] leading-[18px] font-normal',
        ],
      ]);
    }

    public function google_fonts()
    {
      add_action('wp_head', function () {
        ?>
        <link rel="preload"
          href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap" as="style"
          onload="this.onload=null;this.rel='stylesheet'" />
        <noscript>
          <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet" type="text/css" />
        </noscript>
        <?php
      }, 5);
    }

    public function localizes_scripts()
    {
      $name_app = 'app';
      $src_app = '';
      if (tenaspace_is_vite_dev_mode()) {
        $src_app = PUBLIC_URI . '/app.js';
      } else {
        $manifest = tenaspace_get_manifest();
        if (isset($manifest['src/app.js']['file']) && !empty($manifest['src/app.js']['file'])) {
          $src_app = PUBLIC_URI . '/' . $manifest['src/app.js']['file'];
        }
      }
      wp_register_script($name_app, $src_app, [], null);
      wp_enqueue_script($name_app);
      wp_localize_script($name_app, $name_app, [
        'adminAjaxUrl' => admin_url('admin-ajax.php'),
      ]);
    }

    public function scripts()
    {
      global $name_main;
      $name_main = 'main';
      if (tenaspace_is_vite_dev_mode()) {
        function get_scripts()
        {
          global $name_main;
          echo '<script type="module" crossorigin src="' . PUBLIC_URI . '/' . $name_main . '.js"></script>';
        }

        add_action('wp_head', function () {
          get_scripts();
        }, 99999);
      } else {
        function get_css()
        {
          global $name_main;
          $manifest_values = tenaspace_get_manifest_values();
          if (sizeof($manifest_values) > 0) {
            foreach ($manifest_values as $manifest_value) {
              if (isset($manifest_value['css']) && is_array($manifest_value) && sizeof($manifest_value['css']) > 0) {
                foreach ($manifest_value['css'] as $key => $css) {
                  wp_enqueue_style($name_main . '-' . $key, PUBLIC_URI . '/' . $css, [], null, 'all');
                }
              }
            }
          }
        }

        function get_js()
        {
          global $name_main;
          $manifest_values = tenaspace_get_manifest_values();
          if (sizeof($manifest_values) > 0) {
            foreach ($manifest_values as $manifest_value) {
              if (isset($manifest_value['css']) && is_array($manifest_value) && sizeof($manifest_value['css']) > 0) {
                if (isset($manifest_value['file']) && !empty($manifest_value['file'])) {
                  echo '<script type="text/javascript" src="' . PUBLIC_URI . '/' . $manifest_value['file'] . '" id="' . $name_main . '-js"></script>';
                }
              }
            }
          }
        }

        add_action('wp_enqueue_scripts', function () {
          get_css();
        }, 99999);

        add_action('wp_footer', function () {
          get_js();
        }, 99999);
      }
    }

    public function body_classes($classes)
    {
      $tw = TailwindMerge::instance();
      $classes = [
        $tw->merge(array_merge([
          CLASSES['typography']['base'],
          'font-be-vietnam-pro bg-white text-black dark:bg-white dark:text-black',
        ], $classes))
      ];
      return $classes;
    }

    public function widgets()
    {
      register_sidebar(
        array(
          'name' => __('test', 'tenaspace'),
          'id' => 'test',
          'description' => '',
        )
      );
    }

    public function custom_blocks()
    {
      $blocks = glob(get_template_directory() . '/build/custom-blocks/*/');
      if (isset($blocks) && is_array($blocks) && sizeof($blocks) > 0) {
        foreach ($blocks as $block) {
          register_block_type($block);
        }
      }

      function register_custom_blocks_category($categories)
      {

        $categories[] = array(
          'slug' => 'custom-blocks',
          'title' => 'Custom blocks'
        );

        return $categories;
      }

      if (version_compare(get_bloginfo('version'), '5.8', '>=')) {
        add_filter('block_categories_all', 'register_custom_blocks_category');
      } else {
        add_filter('block_categories', 'register_custom_blocks_category');
      }
    }
  }
}

return new Tenaspace();

?>