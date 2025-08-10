<?php
namespace TS;

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
  }
}