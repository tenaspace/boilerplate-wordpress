<?php
use KubAT\PhpSimple\HtmlDomParser;

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
      $this->alpine_start();
      add_filter('body_class', [$this, 'body_classes']);
      $this->custom_hooks();
    }

    public function setup()
    {
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
        $dotenv = Dotenv\Dotenv::createImmutable(get_template_directory());
        $dotenv->safeLoad();
        $vite_server_port = $_ENV['VITE_SERVER_PORT'] ?? 3000;

        $public_path = get_template_directory() . '/src';
        $public_uri = 'http://localhost:' . $vite_server_port . '/src';
      }

      define('PUBLIC_PATH', $public_path);
      define('PUBLIC_URI', $public_uri);
    }

    public function google_fonts()
    {
      add_action('wp_head', function () {
        echo '<link rel="profile" href="https://gmpg.org/xfn/11">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">';
      }, 10);
    }

    public function scripts()
    {
      /**
       * Remove CSS
       */
      // add_action('wp_enqueue_scripts', function () {
      //   global $wp_styles;
      //   foreach ($wp_styles->queue as $handle) {
      //     if (strpos($handle, 'wp-block-') === 0) {
      //       wp_dequeue_style($handle);
      //     }
      //   }
      //   wp_dequeue_style('classic-theme-styles');
      //   wp_dequeue_style('global-styles');
      // }, 99999);

      /**
       * Add CSS & JS
       */
      global $name_main;
      $name_main = 'main';
      if (vs_is_vite_dev_mode()) {
        function get_scripts()
        {
          global $name_main;
          echo '<script type="module" crossorigin src="' . PUBLIC_URI . '/' . $name_main . '.js"></script>';
        }

        add_action('wp_head', function () {
          get_scripts();
        }, 99998);
      } else {
        function get_css()
        {
          global $name_main;
          $manifest = json_decode(file_get_contents(PUBLIC_URI . '/manifest.json'), true);
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
          $manifest = json_decode(file_get_contents(PUBLIC_URI . '/manifest.json'), true);
          if (is_array($manifest)) {
            $manifest_values = array_values($manifest);
            if (sizeof($manifest_values) > 0) {
              foreach ($manifest_values as $manifest_value) {
                if (isset($manifest_value['css']) && is_array($manifest_value) && sizeof($manifest_value['css']) > 0) {
                  if (isset($manifest_value['file']) && !empty($manifest_value['file'])) {
                    wp_enqueue_script($name_main, PUBLIC_URI . '/' . $manifest_value['file'], [], false, true);
                  }
                }
              }
            }
          }
        }

        add_action('wp_enqueue_scripts', function () {
          get_css();
          get_js();
        }, 99998);
      }
    }

    public function alpine_start()
    {
      global $name_alpine_start;
      $name_alpine_start = 'alpine-start';
      if (tenaspace_is_vite_dev_mode()) {
        add_action('wp_footer', function () {
          global $name_alpine_start;
          echo '<script type="module" crossorigin src="' . PUBLIC_URI . '/' . $name_alpine_start . '.js"></script>';
        }, 99999);
      } else {
        add_action('wp_enqueue_scripts', function () {
          global $name_alpine_start;
          $manifest = json_decode(file_get_contents(PUBLIC_URI . '/manifest.json'), true);
          if (is_array($manifest)) {
            $manifest_values = array_values($manifest);
            if (sizeof($manifest_values) > 0) {
              foreach ($manifest_values as $manifest_value) {
                if (isset($manifest_value['src']) && $manifest_value['src'] === 'src/' . $name_alpine_start . '.js') {
                  if (isset($manifest_value['file']) && !empty($manifest_value['file'])) {
                    wp_enqueue_script($name_alpine_start, PUBLIC_URI . '/' . $manifest_value['file'], [], false, true);
                  }
                }
              }
            }
          }
        }, 99999);
      }
    }

    public function body_classes($classes)
    {
      $classes = array_merge([
        'antialiased',
        'font-inter',
        'text-base',
      ], $classes);
      return $classes;
    }

    public function custom_hooks()
    {
      /**
       * Disable Heartbeat
       */
      // add_action('init', function() {
      //   wp_deregister_script('heartbeat');
      // });

      /**
       * Disabled XML-RPC
       */
      add_filter('xmlrpc_enabled', '__return_false');

      /**
       * Log Mail
       */
      add_action('wp_mail_failed', function ($wp_error) {
        $fn = WP_CONTENT_DIR . '/mail.log';
        $fp = fopen($fn, 'a');
        fputs($fp, "Mailer Error: " . $wp_error->get_error_message() . "\n");
        fclose($fp);
      }, 10, 1);

      /**
       * Allow Form Multiple Upload
       */
      add_action('post_edit_form_tag', function () {
        echo ' enctype="multipart/form-data"';
      });

      /**
       * The Menu
       */
      add_filter('wp_get_nav_menu_items', function ($items, $menu, $args) {
        _wp_menu_item_classes_by_context($items);
        return $items;
      }, 10, 3);

      /**
       * The Archive - Title
       */
      add_filter('get_the_archive_title', function ($title) {
        if (is_category()) {
          $title = single_cat_title('', false);
        } elseif (is_tag()) {
          $title = single_tag_title('', false);
        } elseif (is_author()) {
          $title = '<span class="vcard">' . get_the_author() . '</span>';
        } elseif (is_tax()) { //for custom post types
          $title = sprintf(__('%1$s'), single_term_title('', false));
        } elseif (is_post_type_archive()) {
          $title = post_type_archive_title('', false);
        }
        return $title;
      });

      /**
       * The Excerpt
       */
      add_filter('excerpt_more', function ($dots) {
        return '...';
      });

      /**
       * The Content - Hash ID For H Tag
       */
      if (class_exists('ACF')) {
        add_filter('the_content', function ($content) {
          if (!$content) {
            return;
          }
          $toc_settings = get_post_meta(get_the_ID(), 'table_of_contents', true);
          if ($content && is_array($toc_settings) && sizeof($toc_settings) > 0) {
            $content = HtmlDomParser::str_get_html($content);
            foreach ($toc_settings as $k => $v) {
              foreach ($content->find($v) as $element) {
                $element->setAttribute('id', sanitize_title(trim($element->plaintext)));
              }
            }
          }
          return $content;
        }, 15, 1);
      }
    }
  }
}

return new Tenaspace();

?>