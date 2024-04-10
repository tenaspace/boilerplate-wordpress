<?php
use KubAT\PhpSimple\HtmlDomParser;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use TailwindMerge\TailwindMerge;

if (!class_exists('Ts_Functions')) {
  class Ts_Functions
  {
    /**
     * Write log
     */

    public function write_log($log)
    {
      if (WP_DEBUG === true) {
        if (is_array($log) || is_object($log)) {
          error_log(print_r($log, true));
        } else {
          error_log($log);
        }
      }
    }

    /**
     * Check Vite Dev Mode
     */

    public function is_vite_dev_mode()
    {
      return !file_exists(get_template_directory() . '/dist/.vite/manifest.json');
    }

    /**
     * Get manifest
     */

    public function get_manifest()
    {
      return json_decode(file_get_contents(get_template_directory() . '/dist/.vite/manifest.json'), true);
    }

    /**
     * Get manifest values
     */

    public function get_manifest_values()
    {
      $manifest = $this->get_manifest();
      return is_array($manifest) ? array_values($manifest) : [];
    }

    /**
     * Require All Files In Folder
     */

    public function require_all_files($path)
    {
      $dir = new RecursiveDirectoryIterator(get_template_directory() . $path);
      $iterator = new RecursiveIteratorIterator($dir);
      foreach ($iterator as $file) {
        $fname = $file->getFilename();
        if (preg_match('%\.php$%', $fname)) {
          require_once ($file->getPathname());
        }
      }
    }

    /**
     * Check WooCommerce is activated
     */

    public function is_woocommerce_activated()
    {
      return class_exists('WooCommerce') ? true : false;
    }

    /**
     * clsx PHP
     */

    public function clsx(...$args)
    {
      $classNames = [];

      foreach ($args as $arg) {
        if (is_array($arg)) {
          foreach ($arg as $key => $value) {
            if (is_string($key)) {
              if (is_array($value)) {
                $classNames = array_merge($classNames, $value);
              } elseif ($value) {
                $classNames[] = $key;
              }
            } elseif (is_string($value)) {
              $classNames = array_merge($classNames, explode(' ', $value));
            } elseif (is_array($value)) {
              $classNames[] = $this->clsx($value);
            } elseif (is_object($value)) {
              foreach ($value as $class => $condition) {
                if ($condition) {
                  $classNames[] = $class;
                }
              }
            }
          }
        } elseif (is_string($arg)) {
          $classNames = array_merge($classNames, explode(' ', $arg));
        }
      }

      // Remove duplicates
      $classNames = array_unique($classNames);

      return implode(' ', $classNames);
    }

    /**
     * Tailwind Merge PHP
     */

    public function tw_merge(...$args)
    {
      $tw = TailwindMerge::instance();
      return $tw->merge(...$args);
    }

    /**
     * Tailwind Merge + clsx PHP
     */

    public function cn(...$args) {
      return $this->tw_merge($this->clsx(...$args));
    }

    /**
     * Verify reCAPTCHA v3
     */

    public function recaptcha_verify($token, $action)
    {
      $recaptcha = new \ReCaptcha\ReCaptcha($_ENV['GOOLE_RECAPTCHA_SECRET_KEY'] ?? '');
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
     * Limit Word
     */

    public function limit_words($string, $limit = 25)
    {
      return preg_replace('/((\w+\W*){' . ($limit - 1) . '}(\w+))(.*)/', '${1}', $string) . ((str_word_count($string) > $limit) ? '...' : '');
    }

    /**
     * Get Nav Menu Items
     */

    public function get_nav_menu_items(array &$nav_menu_items, $parent_id = 0)
    {
      $result = [];
      foreach ($nav_menu_items as &$item) {
        if ($item->menu_item_parent == $parent_id) {
          $children = $this->get_nav_menu_items($nav_menu_items, $item->ID);
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

    /**
     * Get Nav Menu
     */

    public function get_nav_menu($theme_location)
    {
      $items = wp_get_nav_menu_items($theme_location);
      return $items ? $this->get_nav_menu_items($items) : [];
    }

    /**
     * Get Attachment ID By URL
     */

    public function get_attachment_id_by_url($url)
    {
      $url = preg_replace('/-\d+[Xx]\d+\./', '.', $url);
      return attachment_url_to_postid($url);
    }

    /**
     * Table Of Contents
     */

    public function get_table_of_contents($post_id)
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

    public function get_toc_items(array &$toc, $parent_id = 0)
    {
      if (!$toc) {
        return;
      }
      $result = [];
      foreach ($toc as $key => &$item) {
        if ($item['parent_id'] === $parent_id) {
          $children = $this->get_toc_items($toc, $item['id']);
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

    public function get_toc($post_id)
    {
      $items = $this->get_table_of_contents($post_id);
      return is_array($items) && sizeof($items) > 0 ? $this->get_toc_items($items) : [];
    }
  }
}

?>