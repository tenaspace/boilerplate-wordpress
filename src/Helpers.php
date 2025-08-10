<?php
namespace TS;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use KubAT\PhpSimple\HtmlDomParser;

class Helpers
{
  private $vite_manifest_path;

  public function __construct()
  {
    $this->vite_manifest_path = '/dist/.vite/manifest.json';
  }

  public function is_vite_dev_mode()
  {
    return !file_exists(get_template_directory() . $this->vite_manifest_path);
  }

  public function is_woocommerce_activated()
  {
    return class_exists('WooCommerce');
  }

  public function is_pll_activated()
  {
    return function_exists('pll_current_language');
  }

  public function get_manifest()
  {
    return json_decode(file_get_contents(get_template_directory() . $this->vite_manifest_path), true);
  }

  public function get_manifest_values()
  {
    $manifest = $this->get_manifest();
    if (!(isset($manifest) && is_array($manifest) && sizeof((array) $manifest) > 0)) {
      return;
    }
    return array_values($manifest);
  }

  public function body_open()
  {
    do_action('wp_body_open');
  }

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
        $mail->Host = $_ENV['SMTP_HOST'] || '';
        $mail->Username = $_ENV['SMTP_USERNAME'] || '';
        $mail->Password = $_ENV['SMTP_PASSWORD'] || '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $_ENV['SMTP_PORT'] || '';
      }
    } catch (Exception $error) {
      app()->utils->write_log($error->errorMessage());
      app()->utils->write_log($mail->ErrorInfo);
    }
    return $mail;
  }

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

  public function get_nav_menu(string $location)
  {
    $items = $this->create_nav_menu($location);
    if (!(isset($items) && is_array($items) && sizeof((array) $items) > 0)) {
      return;
    }
    return $this->get_nav_menu_items($items);
  }

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
      unset($item['id']);
      unset($item['parent_id']);
      return $item;
    }, array_values(array_filter($result)));
    return $result;
  }

  public function get_table_of_contents(bool|int $post_id)
  {
    $items = $this->create_table_of_contents($post_id);
    if (!(isset($items) && is_array($items) && sizeof((array) $items) > 0)) {
      return;
    }
    return $this->get_table_of_contents_items($items);
  }

  public function get_breadcrumb()
  {
    $result = [];
    $is_woocommerce = app()->helpers->is_woocommerce_activated() && \is_woocommerce();
    if ($is_woocommerce && (\is_product() || \is_product_taxonomy())) {
      array_push($result, [
        'link' => esc_url(get_permalink(\wc_get_page_id('shop'))),
        'label' => get_the_title(\wc_get_page_id('shop')),
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
          $taxonomy = $object_taxonomies[0];
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
    if (is_archive() || ($is_woocommerce && \is_product_taxonomy())) {
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
        'label' => app()->i18n->translate([
          'en' => 'Search for keywords',
          'vi' => 'Tìm kiếm cho từ khóa'
        ]) . ': ' . get_search_query(),
      ]);
    }
    if (is_404()) {
      array_push($result, [
        'link' => '',
        'label' => app()->i18n->translate([
          'en' => 'Page not found',
          'vi' => 'Không tìm thấy nội dung này'
        ]),
      ]);
    }
    return $result;
  }
}