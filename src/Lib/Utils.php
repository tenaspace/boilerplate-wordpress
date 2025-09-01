<?php
namespace TS\Lib;
use TailwindMerge\TailwindMerge;

class Utils
{
  public function __construct()
  {

  }

  public function write_log($log)
  {
    if (!isset($log)) {
      return;
    }
    if (is_array($log) || is_object($log)) {
      error_log(print_r($log, true));
    } else {
      error_log($log);
    }
  }

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
    $class = array_unique($class);
    return implode(' ', $class);
  }

  public function tw_merge(...$args)
  {
    $tw = TailwindMerge::instance();
    return $tw->merge(...$args);
  }

  public function cn(...$args)
  {
    return $this->tw_merge($this->clsx(...$args));
  }

  public function limit_words(string $text, int $limit = 25)
  {
    if (empty($text)) {
      return;
    }
    return preg_replace('/((\w+\W*){' . ($limit - 1) . '}(\w+))(.*)/', '${1}', $text) . ((str_word_count($text) > $limit) ? '...' : '');
  }
}