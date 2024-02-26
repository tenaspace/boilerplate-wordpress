<?php
use KubAT\PhpSimple\HtmlDomParser;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('tenaspace_write_log')) {
  function tenaspace_write_log($log)
  {
    if (WP_DEBUG === true) {
      if (is_array($log) || is_object($log)) {
        error_log(print_r($log, true));
      } else {
        error_log($log);
      }
    }
  }

}

/**
 * Check Vite Dev Mode
 */

if (!function_exists('tenaspace_is_vite_dev_mode')) {
  function tenaspace_is_vite_dev_mode()
  {
    return !file_exists(get_template_directory() . '/dist/.vite/manifest.json');
  }
}

/**
 * Require All Files In Folder
 */

if (!function_exists('tenaspace_require_all_files')) {
  function tenaspace_require_all_files($path, $deep = true, $excludes = [])
  {
    foreach (glob(get_template_directory() . $path . ($deep ? '/**' : '') . '/*.php') as $filename) {
      $explode = explode('/', $filename);
      if (!in_array(str_replace('.php', '', end($explode)), $excludes)) {
        require_once($filename);
      }
    }
  }
}

/**
 * Check WooCommerce is activated
 */

if (!function_exists('tenaspace_is_woocommerce_activated')) {
  function tenaspace_is_woocommerce_activated()
  {
    return class_exists('WooCommerce') ? true : false;
  }
}

/**
 * Verify reCAPTCHA v3
 */

if (!function_exists('tenaspace_recaptcha_verify')) {
  function tenaspace_recaptcha_verify($token, $action)
  {
    $recaptcha = new \ReCaptcha\ReCaptcha($_ENV['GOOLE_RECAPTCHA_SECRET_KEY'] ?? '');
    $verify = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
      ->setExpectedAction($action)
      ->setScoreThreshold(0.5)
      ->verify($token, $_SERVER['REMOTE_ADDR']);
    return $verify->toArray();
  }
}

/**
 * Mailer
 */

if (!function_exists('tenaspace_mailer')) {
  function tenaspace_mailer()
  {
    $mail = new PHPMailer(true);
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
      tenaspace_write_log($mail->ErrorInfo);
    }
    return $mail;
  }
}

/**
 * Limit Word
 */

if (!function_exists('tenaspace_limit_words')) {
  function tenaspace_limit_words($string, $limit = 25)
  {
    return preg_replace('/((\w+\W*){' . ($limit - 1) . '}(\w+))(.*)/', '${1}', $string) . ((str_word_count($string) > $limit) ? '...' : '');
  }
}

/**
 * Get Nav Menu Items
 */

if (!function_exists('tenaspace_get_nav_menu_items')) {
  function tenaspace_get_nav_menu_items(array &$nav_menu_items, $parent_id = 0)
  {
    $result = [];
    foreach ($nav_menu_items as &$item) {
      if ($item->menu_item_parent == $parent_id) {
        $children = tenaspace_get_nav_menu_items($nav_menu_items, $item->ID);
        if ($children) {
          $item->children = $children;
        }
        $result[$item->ID] = $item;
        unset($item);
      }
    }
    $result = array_values(array_filter($result));
    return $result;
  }
}

/**
 * Get Nav Menu
 */

if (!function_exists('tenaspace_get_nav_menu')) {
  function tenaspace_get_nav_menu($theme_location)
  {
    $items = wp_get_nav_menu_items($theme_location);
    return $items ? tenaspace_get_nav_menu_items($items) : [];
  }
}

/**
 * Get Attachment ID By URL
 */

if (!function_exists('tenaspace_get_attachment_id_by_url')) {
  function tenaspace_get_attachment_id_by_url($url)
  {
    $url = preg_replace('/-\d+[Xx]\d+\./', '.', $url);
    return attachment_url_to_postid($url);
  }
}

/**
 * Table Of Contents
 */

if (!function_exists('tenaspace_get_table_of_contents')) {
  function tenaspace_get_table_of_contents($post_id)
  {
    if (!$post_id) {
      return;
    }
    $content = HtmlDomParser::str_get_html(str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content($post_id))));
    $result = [];
    if (class_exists('ACF')) {
      $toc_settings = get_post_meta($post_id, 'table_of_contents', true);
      if (isset($content) && is_array($toc_settings) && sizeof($toc_settings) > 0) {
        $heading_tags = [];
        foreach ($toc_settings as $k => $v) {
          if ($content->find($v)) {
            array_push($heading_tags, $v);
          }
        }
        if (is_array($heading_tags) && sizeof($heading_tags) > 0) {
          $heading_tags_shift = $heading_tags;
          array_shift($heading_tags_shift);
          foreach ($content->find($heading_tags[0]) as $k => $v) {
            $current[$heading_tags[0]] = $k;
            $parent_id = 0;
            array_push($result, [
              'id' => $v->tag . '-' . $k,
              'tag' => $v->tag,
              'text' => trim($v->plaintext),
              'hash' => sanitize_title(trim($v->plaintext)),
              'uri' => rtrim(str_replace(home_url(), '', get_the_permalink($post_id)), '/'),
              'url' => rtrim(get_the_permalink($post_id), '/') . '#' . sanitize_title(trim($v->plaintext)),
              'parent_id' => $parent_id,
            ]);
            if (is_array($heading_tags) && sizeof($heading_tags) > 1) {
              $prev_tag = $v->tag;
              while (($v = $v->next_sibling()) && strcmp($v->tag, $heading_tags[0]) !== 0) {
                foreach ($heading_tags_shift as $key => $value) {
                  if (strcmp($v->tag, $value) == 0) {
                    if (strcmp($value, $prev_tag) == 0) {
                      $parent_id = $result[array_key_last($result)]['parent_id'];
                    } else {
                      if (array_search($value, $heading_tags) > array_search($prev_tag, $heading_tags)) {
                        $current[$value] = 0;
                        $parent_id = $result[array_key_last($result)]['id'];
                      } else {
                        $parent_id = $result[array_search($result[array_key_last($result)]['parent_id'], array_column($result, 'id'))]['parent_id'];
                      }
                    }
                    array_push($result, [
                      'id' => $value . '-' . $current[$value],
                      'tag' => $value,
                      'text' => trim($v->plaintext),
                      'hash' => sanitize_title(trim($v->plaintext)),
                      'uri' => rtrim(str_replace(home_url(), '', get_the_permalink($post_id)), '/'),
                      'url' => rtrim(get_the_permalink($post_id), '/') . '#' . sanitize_title(trim($v->plaintext)),
                      'parent_id' => $parent_id,
                    ]);
                    $current[$value] += 1;
                    $prev_tag = $value;
                  }
                }
              }
            }
          }
        }
      }
    }
    return $result;
  }
}

if (!function_exists('tenaspace_get_toc_items')) {
  function tenaspace_get_toc_items(array &$toc, $parent_id = 0)
  {
    if (!$toc) {
      return;
    }
    $result = [];
    foreach ($toc as $key => &$item) {
      if ($item['parent_id'] === $parent_id) {
        $children = tenaspace_get_toc_items($toc, $item['id']);
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
}

if (!function_exists('tenaspace_get_toc')) {
  function tenaspace_get_toc($post_id)
  {
    $items = tenaspace_get_table_of_contents($post_id);
    return is_array($items) && sizeof($items) > 0 ? tenaspace_get_toc_items($items) : [];
  }
}

?>