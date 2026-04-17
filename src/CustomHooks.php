<?php
namespace TS;
use KubAT\PhpSimple\HtmlDomParser;

class CustomHooks
{
  public function __construct()
  {
    $this->hooks();
  }

  protected function hooks()
  {
    // add_action('init', function() {
    //   wp_deregister_script('heartbeat');
    // });

    add_filter('xmlrpc_enabled', '__return_false');

    add_action('wp_mail_failed', function ($wp_error) {
      $fn = WP_CONTENT_DIR . '/mail.log';
      $fp = fopen($fn, 'a');
      fputs($fp, "Mailer Error: " . $wp_error->get_error_message() . "\n");
      fclose($fp);
    }, 10, 1);

    add_action('post_edit_form_tag', function () {
      echo ' enctype="multipart/form-data"';
    });

    add_filter('wp_get_nav_menu_items', function ($items) {
      _wp_menu_item_classes_by_context($items);
      return $items;
    }, 10, 1);

    add_filter('get_the_archive_title', function ($title) {
      if (is_category()) {
        $title = single_cat_title('', false);
      } elseif (is_tag()) {
        $title = single_tag_title('', false);
      } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
      } elseif (is_tax()) {
        $title = sprintf(__('%1$s'), single_term_title('', false));
      } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
      }
      return $title;
    });

    add_filter('excerpt_more', function ($dots) {
      return '…';
    }, 10, 1);

    add_filter('the_content', function ($content) {
      global $post;
      $post_id = $post->ID;
      if (empty($post_id)) {
        return $content;
      }
      if (!class_exists('ACF')) {
        return $content;
      }
      $dom = HtmlDomParser::str_get_html($content);
      $heading_tags_setting = get_post_meta($post_id, 'table_of_contents', true);
      if (!(!empty($dom) && \is_array($heading_tags_setting) && !empty($heading_tags_setting))) {
        return $content;
      }
      $heading_tags = [];
      foreach ($heading_tags_setting as $heading_tag) {
        if ($dom->find($heading_tag)) {
          array_push($heading_tags, $heading_tag);
        }
      }
      if (!(isset($heading_tags) && \is_array($heading_tags) && !empty($heading_tags))) {
        return $content;
      }
      foreach ($heading_tags as $heading_tag) {
        foreach ($dom->find($heading_tag) as $node) {
          $id = isset($node->id) && !empty($node->id) ? $node->id : sanitize_title(trim($node->plaintext));
          $node->setAttribute('id', $id);
        }
      }
      $the_content = $dom->save();
      $dom->clear();
      unset($dom);
      return $the_content;
    }, 10, 1);

    /** ===== */

    add_action('admin_menu', function () {
      if (!is_super_admin()) {
        remove_menu_page('edit.php?post_type=acf-field-group');
        remove_menu_page('plugins.php');
      }
    }, 999);

    add_action('current_screen', function ($screen) {
      if (!is_super_admin()) {
        $acf_screens = [
          'acf-field-group',
          'edit-acf-field-group',
          'plugins',
        ];
        if (\in_array($screen->id, $acf_screens, true)) {
          wp_die(
            __('Sorry, you are not allowed to do that.', 'ts'),
            __('Forbidden', 'ts'),
            ['response' => 403]
          );
        }
      }
    });

    add_action('admin_init', function () {
      global $pagenow;
      if (!is_super_admin() && $pagenow === 'plugins.php') {
        wp_die(
          __('Sorry, you are not allowed to do that.', 'ts'),
          __('Forbidden', 'ts'),
          ['response' => 403]
        );
      }
    });
  }
}