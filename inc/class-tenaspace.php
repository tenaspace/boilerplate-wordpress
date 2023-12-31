<?php
if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Tenaspace')) {
  class Tenaspace
  {
    public function __construct()
    {
      add_action('after_setup_theme', [$this, 'setup']);
      $this->defines();
      $this->google_fonts();
      $this->scripts();
      add_filter('body_class', [$this, 'body_classes']);
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
          'h1' => 'text-[81px] leading-tight font-bold md:text-[91px] md:leading-tight lg:text-[101px] lg:leading-tight',
          'h2' => 'text-[54px] leading-tight font-bold md:text-[60px] md:leading-tight lg:text-[68px] lg:leading-tight',
          'h3' => 'text-[36px] leading-normal font-bold md:text-[42px] md:leading-normal lg:text-[45px] lg:leading-normal',
          'h4' => 'text-[24px] leading-normal font-medium md:text-[27px] md:leading-normal lg:text-[30px] lg:leading-normal',
          'leading' => 'text-[18px] leading-normal font-normal',
          'body' => 'text-[16px] leading-normal font-normal',
          'link' => 'text-[16px] leading-normal font-medium underline',
          'button' => 'text-[16px] leading-normal font-medium tracking-[0.4px]',
          'caption' => 'text-[16px] leading-normal font-normal text-ts-gray',
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
          $manifest = json_decode(file_get_contents(PUBLIC_URI . '/.vite/manifest.json'), true);
          if (is_array($manifest)) {
            $manifest_values = array_values($manifest);
            if (sizeof($manifest_values) > 0) {
              foreach ($manifest_values as $manifest_value) {
                if (isset($manifest_value['css']) && is_array($manifest_value) && sizeof($manifest_value['css']) > 0) {
                  foreach ($manifest_value['css'] as $key => $css) {
                    wp_enqueue_style($name_main . '-' . $key, PUBLIC_URI . '/' . $css, [], false, 'all');
                  }
                }
              }
            }
          }
        }

        function get_js()
        {
          global $name_main;
          $manifest = json_decode(file_get_contents(PUBLIC_URI . '/.vite/manifest.json'), true);
          if (is_array($manifest)) {
            $manifest_values = array_values($manifest);
            if (sizeof($manifest_values) > 0) {
              foreach ($manifest_values as $manifest_value) {
                if (isset($manifest_value['css']) && is_array($manifest_value) && sizeof($manifest_value['css']) > 0) {
                  if (isset($manifest_value['file']) && !empty($manifest_value['file'])) {
                    echo '<script type="text/javascript" src="' . PUBLIC_URI . '/' . $manifest_value['file'] . '?ver=' . get_bloginfo('version') . '" id="' . $name_main . '-js"></script>';
                  }
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
      $classes = array_merge([
        'font-be-vietnam-pro',
        CLASSES['body'],
        'bg-white',
        'text-ts-black'
      ], $classes);
      return $classes;
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