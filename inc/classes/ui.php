<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class UI
{
  use Singleton;

  protected function __construct()
  {

  }

  /**
   * Container
   */

  public function container(string $variant = 'default')
  {
    $utils = Utils::instance();

    $variants = [
      'default' => '',
    ];

    return $utils->cn('', $variants[$variant]);
  }

  /**
   * Typography
   */

  public function typography(string $variant = 'default')
  {
    $utils = Utils::instance();
    
    $variants = [
      'default' => '',
    ];

    return $utils->cn('', $variants[$variant]);
  }

  /**
   * Button
   */

  public function button(string $variant = 'default', string $size = 'default')
  {
    $utils = Utils::instance();

    $variants = [
      'default' => '',
    ];

    $sizes = [
      'default' => '',
    ];

    return $utils->cn('', $variants[$variant], $sizes[$size]);
  }
}
?>