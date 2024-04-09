<?php
use TailwindMerge\TailwindMerge;

if (!class_exists('Ts')) {
  class Ts
  {
    public function __construct()
    {
      $this->defines();
      add_action('after_setup_theme', [$this, 'setup']);
      add_action('init', [$this, 'google_fonts']);
      add_action('init', [$this, 'localizes_scripts']);
      add_action('init', [$this, 'scripts']);
      add_filter('body_class', [$this, 'body_classes']);
      add_action('widgets_init', [$this, 'widgets']);
      add_action('init', [$this, 'custom_blocks']);
    }

    /**
     * Get dictionaries
     */

    private function get_dictionaries($locale = '')
    {
      $current_locale = get_locale();
      $i18n = [
        'en_US' => require_once (get_template_directory() . '/inc/dictionaries/en-us.php'),
        'vi' => require_once (get_template_directory() . '/inc/dictionaries/vi.php'),
      ];
      return empty($locale) ? $i18n[$current_locale] : (isset($i18n[$locale]) ? $i18n[$locale] : $i18n['en_US']);
    }

    /**
     * Get public directory
     */

    private function get_public_dir()
    {
      $ts_functions = new Ts_Functions();
      $path = get_template_directory() . '/dist';
      $uri = get_template_directory_uri() . '/dist';
      if ($ts_functions->is_vite_dev_mode()) {
        $vite_server_port = $_ENV['VITE_SERVER_PORT'] ?? 3000;
        $path = get_template_directory() . '/src';
        $uri = 'http://localhost:' . $vite_server_port . '/src';
      }
      return [
        'path' => $path,
        'uri' => $uri,
      ];
    }

    public function defines()
    {
      $public_dir = $this->get_public_dir();

      define('PUBLIC_PATH', $public_dir['path']);
      define('PUBLIC_URI', $public_dir['uri']);

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

      define('DICTIONARIES', $this->get_dictionaries());
    }

    public function setup()
    {
      add_theme_support('title-tag');
      add_theme_support('automatic-feed-links');
      add_theme_support('post-thumbnails');
      register_nav_menus([
        'primary' => __('primary', 'ts'),
      ]);
      add_theme_support('widgets');
    }

    public function google_fonts()
    {
      add_action('wp_head', function () {
        $url = "https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap";
        ?>
        <link rel="preload" href="<?php echo $url; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
        <noscript>
          <link href="<?php echo $url; ?>" rel="stylesheet" type="text/css" />
        </noscript>
        <?php
      }, 5);
    }

    public function localizes_scripts()
    {
      $ts_functions = new Ts_Functions();
      $name_app = 'app';
      $src_app = '';
      if ($ts_functions->is_vite_dev_mode()) {
        $src_app = PUBLIC_URI . '/app.js';
      } else {
        $manifest = $ts_functions->get_manifest();
        if (isset($manifest['src/app.js']['file']) && !empty($manifest['src/app.js']['file'])) {
          $src_app = PUBLIC_URI . '/' . $manifest['src/app.js']['file'];
        }
      }
      wp_register_script($name_app, $src_app, [], null);
      wp_enqueue_script($name_app);
      wp_localize_script($name_app, $name_app, [
        'adminAjaxUrl' => admin_url('admin-ajax.php'),
        'dictionaries' => DICTIONARIES,
      ]);
    }

    public function scripts()
    {
      $ts_functions = new Ts_Functions();
      global $name_main;
      $name_main = 'main';
      if ($ts_functions->is_vite_dev_mode()) {
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
          $ts_functions = new Ts_Functions();
          global $name_main;
          $manifest_values = $ts_functions->get_manifest_values();
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
          $ts_functions = new Ts_Functions();
          global $name_main;
          $manifest_values = $ts_functions->get_manifest_values();
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
      register_sidebar([
        'name' => __('test', 'ts'),
        'id' => 'test',
        'description' => __('', 'ts'),
      ]);
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

        $categories[] = [
          'slug' => 'custom-blocks',
          'title' => 'Custom blocks'
        ];

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

return new Ts();

?>