<?php
namespace TS\Inc\Traits;

trait Singleton
{
  protected function __construct()
  {

  }

  final protected function __clone()
  {

  }

  final public static function instance()
  {
    static $instance = [];

    $called_classes = get_called_class();

    if (!isset($instance[$called_classes])) {
      $instance[$called_classes] = new $called_classes;
    }

    return $instance[$called_classes];
  }
}
?>