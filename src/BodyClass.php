<?php
namespace TS;

class BodyClass
{
  public function __construct()
  {
    $this->hooks();
  }

  protected function hooks()
  {
    add_filter('body_class', [$this, 'body_class']);
  }

  public function body_class($classes)
  {
    $classes = explode(' ', app()->lib->utils->cn('antialiased font-sans', 'bg-white text-black dark:bg-black dark:text-white', app()->ui->typography(), $classes));
    return $classes;
  }
}