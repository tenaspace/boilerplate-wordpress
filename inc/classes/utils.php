<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;
use TailwindMerge\TailwindMerge;
use ReCaptcha\ReCaptcha;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use KubAT\PhpSimple\HtmlDomParser;

class Utils
{
  use Singleton;

  private $vite_manifest_path;

  protected function __construct()
  {
    $this->vite_manifest_path = '/dist/.vite/manifest.json';
  }

  /**
   * Write log
   */

  public function write_log($log)
  {
    if (!(isset($log))) {
      return;
    }
    if (WP_DEBUG === true) {
      if (is_array($log) || is_object($log)) {
        error_log(print_r($log, true));
      } else {
        error_log($log);
      }
    }
  }

  /**
   * Check Vite dev mode
   */

  public function is_vite_dev_mode()
  {
    return !file_exists(get_template_directory() . $this->vite_manifest_path);
  }

  /**
   * Require All Files In Folder
   */

  public function require_all_files(string $path)
  {
    if (!(isset($path) && !empty($path))) {
      return;
    }
    try {
      $dir = new \RecursiveDirectoryIterator(get_template_directory() . $path);
      $iterator = new \RecursiveIteratorIterator($dir);
      foreach ($iterator as $file) {
        $fname = $file->getFilename();
        if (preg_match('%\.php$%', $fname)) {
          require_once ($file->getPathname());
        }
      }
    } catch (\Exception $error) {
      $this->write_log($error->getMessage());
    }
  }

  /**
   * Get manifest
   */

  public function get_manifest()
  {
    return json_decode(file_get_contents(get_template_directory() . $this->vite_manifest_path), true);
  }

  /**
   * Get manifest values
   */

  public function get_manifest_values()
  {
    $manifest = $this->get_manifest();
    if (!(isset($manifest) && is_array($manifest) && sizeof((array) $manifest) > 0)) {
      return;
    }
    return array_values($manifest);
  }

  /**
   * clsx PHP
   */

  public function clsx(...$args)
  {
    $class = [];
    foreach ($args as $arg) {
      if (is_array($arg)) {
        foreach ($arg as $key => $value) {
          if (is_string($key)) {
            if (is_array($value)) {
              $class = array_merge($class, $value);
            } elseif ($value) {
              $class[] = $key;
            }
          } elseif (is_string($value)) {
            $class = array_merge($class, explode(' ', $value));
          } elseif (is_array($value)) {
            $class[] = $this->clsx($value);
          } elseif (is_object($value)) {
            foreach ($value as $class => $condition) {
              if ($condition) {
                $class[] = $class;
              }
            }
          }
        }
      } elseif (is_string($arg)) {
        $class = array_merge($class, explode(' ', $arg));
      }
    }
    // Remove duplicates
    $class = array_unique($class);
    return implode(' ', $class);
  }

  /**
   * Tailwind merge PHP
   */

  public function tw_merge(...$args)
  {
    $tw = TailwindMerge::instance();
    return $tw->merge(...$args);
  }

  /**
   * Tailwind merge PHP + clsx PHP
   */

  public function cn(...$args)
  {
    return $this->tw_merge($this->clsx(...$args));
  }

  /**
   * WP open body
   */

  public function body_open()
  {
    do_action('wp_body_open');
  }

  /**
   * Check WooCommerce is activated
   */

  public function is_woocommerce_activated()
  {
    return class_exists('WooCommerce');
  }

  /**
   * Verify reCAPTCHA v3
   */

  public function recaptcha_verify(string $token, string $action)
  {
    if (!(isset($token) && !empty($token) && isset($action) && !empty($action))) {
      return;
    }
    $recaptcha = new ReCaptcha($_ENV['GOOLE_RECAPTCHA_SECRET_KEY'] ?? '');
    $verify = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
      ->setExpectedAction($action)
      ->setScoreThreshold(0.5)
      ->verify($token, $_SERVER['REMOTE_ADDR']);
    return $verify->toArray();
  }

  /**
   * Mailer
   */

  public function mailer()
  {
    $mail = new PHPMailer(true);
    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    try {
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      if ($_ENV['SENDGRID_API_KEY']) {
        $mail->Host = 'smtp.sendgrid.net';
        $mail->Username = 'apikey';
        $mail->Password = $_ENV['SENDGRID_API_KEY'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
      } else {
        $mail->Host = $_ENV['SMTP_HOST'] ?? '';
        $mail->Username = $_ENV['SMTP_USERNAME'] ?? '';
        $mail->Password = $_ENV['SMTP_PASSWORD'] ?? '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $_ENV['SMTP_PORT'] ?? '';
      }
    } catch (Exception $error) {
      $this->write_log($error->errorMessage());
      $this->write_log($mail->ErrorInfo);
    }
    return $mail;
  }

  /**
   * Limit word
   */

  public function limit_words(string $text, int $limit = 25)
  {
    if (!(isset($text) && !empty($text))) {
      return;
    }
    return preg_replace('/((\w+\W*){' . ($limit - 1) . '}(\w+))(.*)/', '${1}', $text) . ((str_word_count($text) > $limit) ? '...' : '');
  }

  /**
   * Create nav menu
   */

  private function create_nav_menu(string $location)
  {
    if (!(isset($location) && !empty($location))) {
      return;
    }
    $locations = get_nav_menu_locations();
    if (!(isset($locations[$location]) && !empty($locations[$location]))) {
      return;
    }
    $result = wp_get_nav_menu_items($locations[$location]);
    if (!(isset($result) && is_array($result) && sizeof((array) $result) > 0)) {
      return;
    }
    return $result;
  }

  /**
   * Get nav menu items
   */

  private function get_nav_menu_items(array &$items, int $parent_id = 0)
  {
    if (!(isset($items) && is_array($items) && sizeof((array) $items) > 0)) {
      return;
    }
    $result = [];
    foreach ($items as &$item) {
      if ($item->menu_item_parent == $parent_id) {
        $children = $this->get_nav_menu_items($items, $item->ID);
        if ($children) {
          $item->children = $children;
        }
        $result[$item->ID] = $item;
        unset($item);
      }
    }
    return array_values(array_filter($result));
  }

  /**
   * Get nav menu
   */

  public function get_nav_menu(string $location)
  {
    $items = $this->create_nav_menu($location);
    if (!(isset($items) && is_array($items) && sizeof((array) $items) > 0)) {
      return;
    }
    return $this->get_nav_menu_items($items);
  }

  /**
   * Create table of contents
   */

  private function create_table_of_contents(bool|int $post_id)
  {
    if (!$post_id) {
      return;
    }
    if (!class_exists('ACF')) {
      return;
    }
    $the_content = HtmlDomParser::str_get_html(str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content($post_id))));
    $heading_tags_setting = get_post_meta($post_id, 'table_of_contents', true);
    if (!(isset($the_content) && !empty($the_content) && is_array($heading_tags_setting) && sizeof((array) $heading_tags_setting) > 0)) {
      return;
    }
    $heading_tags = [];
    foreach ($heading_tags_setting as $heading_tag) {
      if ($the_content->find($heading_tag)) {
        array_push($heading_tags, $heading_tag);
      }
    }
    if (!(isset($heading_tags) && is_array($heading_tags) && sizeof((array) $heading_tags) > 0)) {
      return;
    }
    $result = [];
    $heading_tags_shift = $heading_tags;
    array_shift($heading_tags_shift);
    $current = [];
    foreach ($the_content->find($heading_tags[0]) as $key => $node) {
      $current[$heading_tags[0]] = $key;
      $parent_id = 0;
      array_push($result, [
        'id' => $node->tag . '-' . $key,
        'tag' => $node->tag,
        'text' => trim($node->plaintext),
        'hash' => sanitize_title(trim($node->plaintext)),
        'uri' => ltrim(rtrim(str_replace(home_url(), '', get_the_permalink($post_id)), '/'), '/'),
        'url' => rtrim(get_the_permalink($post_id), '/') . '#' . sanitize_title(trim($node->plaintext)),
        'parent_id' => $parent_id,
      ]);
      if (sizeof((array) $heading_tags) > 1) {
        $prev_tag = $node->tag;
        while (($node = $node->next_sibling()) && strcmp($node->tag, $heading_tags[0]) !== 0) {
          foreach ($heading_tags_shift as $node_shift) {
            if (strcmp($node->tag, $node_shift) == 0) {
              if (strcmp($node_shift, $prev_tag) == 0) {
                $parent_id = $result[array_key_last($result)]['parent_id'];
              } else {
                if (array_search($node_shift, $heading_tags) > array_search($prev_tag, $heading_tags)) {
                  $current[$node_shift] = 0;
                  $parent_id = $result[array_key_last($result)]['id'];
                } else {
                  $parent_id = $result[array_search($result[array_key_last($result)]['parent_id'], array_column($result, 'id'))]['parent_id'];
                }
              }
              array_push($result, [
                'id' => $node_shift . '-' . $current[$node_shift],
                'tag' => $node_shift,
                'text' => trim($node->plaintext),
                'hash' => sanitize_title(trim($node->plaintext)),
                'uri' => ltrim(rtrim(str_replace(home_url(), '', get_the_permalink($post_id)), '/'), '/'),
                'url' => rtrim(get_the_permalink($post_id), '/') . '#' . sanitize_title(trim($node->plaintext)),
                'parent_id' => $parent_id,
              ]);
              $current[$node_shift] += 1;
              $prev_tag = $node_shift;
            }
          }
        }
      }
    }
    return $result;
  }

  /**
   * Get table of contents items
   */

  private function get_table_of_contents_items(array &$items, $parent_id = 0)
  {
    if (!(isset($items) && is_array($items) && sizeof((array) $items) > 0)) {
      return;
    }
    $result = [];
    foreach ($items as $key => &$item) {
      if ($item['parent_id'] === $parent_id) {
        $children = $this->get_table_of_contents_items($items, $item['id']);
        if ($children) {
          $item['children'] = $children;
        }
        $result[$key] = $item;
        unset($item);
      }
    }
    $result = array_map(function ($item) {
      unset ($item['id']);
      unset ($item['parent_id']);
      return $item;
    }, array_values(array_filter($result)));
    return $result;
  }

  /**
   * Get table of contents
   */

  public function get_table_of_contents(bool|int $post_id)
  {
    $items = $this->create_table_of_contents($post_id);
    if (!(isset($items) && is_array($items) && sizeof((array) $items) > 0)) {
      return;
    }
    return $this->get_table_of_contents_items($items);
  }

  /**
   * Get breadcrumb
   */

  public function get_breadcrumb()
  {
    $dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'breadcrumb']);
    $result = [];
    $is_woocommerce = $this->is_woocommerce_activated() && is_woocommerce();
    if ($is_woocommerce && (is_product() || is_product_taxonomy())) {
      array_push($result, [
        'link' => esc_url(get_permalink(wc_get_page_id('shop'))),
        'label' => get_the_title(wc_get_page_id('shop')),
      ]);
    }
    if (is_singular()) {
      $queried_object = get_queried_object();
      $post_type = get_post_type($queried_object);
      $post_type_object = get_post_type_object($post_type);
      if ($post_type_object->has_archive) {
        array_push($result, [
          'link' => get_post_type_archive_link($post_type),
          'label' => $post_type_object->label,
        ]);
      }
      if (is_single()) {
        $object_taxonomies = get_object_taxonomies($post_type);
        if ($object_taxonomies) {
          $taxonomy = $object_taxonomies[0]; // Assuming only one hierarchical taxonomy is used
          if ($post_type === 'post') {
            $taxonomy = 'category';
          }
          if ($is_woocommerce) {
            $taxonomy = 'product_cat';
          }
          $terms = get_the_terms($queried_object, $taxonomy);
          if (isset($terms) && is_array($terms) && sizeof((array) $terms) > 0) {
            $term = array_shift($terms);
            $ancestors = get_ancestors($term->term_id, $taxonomy, 'taxonomy');
            $ancestors = array_reverse($ancestors);
            if (isset($ancestors) && is_array($ancestors) && sizeof((array) $ancestors) > 0) {
              foreach ($ancestors as $ancestor_id) {
                $ancestor = get_term($ancestor_id, $taxonomy);
                array_push($result, [
                  'link' => esc_url(get_term_link($ancestor->term_id, $ancestor->taxonomy)),
                  'label' => $ancestor->name,
                ]);
              }
            }
            array_push($result, [
              'link' => esc_url(get_term_link($term->term_id, $term->taxonomy)),
              'label' => $term->name,
            ]);
          }
        }
      }
      array_push($result, [
        'link' => '',
        'label' => $queried_object->post_title,
      ]);
    }
    if (is_archive() || ($is_woocommerce && is_product_taxonomy())) {
      $term = get_queried_object();
      if ($term->parent) {
        $ancestors = get_ancestors($term->term_id, $term->taxonomy);
        $ancestors = array_reverse($ancestors);
        if (isset($ancestors) && is_array($ancestors) && sizeof((array) $ancestors) > 0) {
          foreach ($ancestors as $ancestor_id) {
            $ancestor = get_term($ancestor_id, $term->taxonomy);
            array_push($result, [
              'link' => esc_url(get_term_link($ancestor->term_id, $ancestor->taxonomy)),
              'label' => $ancestor->name,
            ]);
          }
        }
      }
      array_push($result, [
        'link' => '',
        'label' => get_the_archive_title(),
      ]);
    }
    if (is_search()) {
      array_push($result, [
        'link' => '',
        'label' => $dict('searchForKeywords') . ': ' . get_search_query(),
      ]);
    }
    if (is_404()) {
      array_push($result, [
        'link' => '',
        'label' => $dict('notFound'),
      ]);
    }
    return $result;
  }
}
?>