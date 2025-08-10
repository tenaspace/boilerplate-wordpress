<?php
namespace TS;

class Ui
{
  public function __construct()
  {

  }

  public function container(string $variant = 'default')
  {
    $variants = [
      'default' => '',
    ];
    return app()->utils->cn('', $variants[$variant]);
  }

  public function typography(string $variant = 'default')
  {
    $variants = [
      'default' => '',
    ];
    return app()->utils->cn('', $variants[$variant]);
  }

  public function button(string $variant = 'default', string $size = 'default')
  {
    $variants = [
      'default' => '',
    ];
    $sizes = [
      'default' => '',
    ];
    return app()->utils->cn('', $variants[$variant], $sizes[$size]);
  }
}