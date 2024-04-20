<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;
use TS\Inc\Utils;

class Require_Folders
{
  use Singleton;

  protected function __construct()
  {
    $utils = Utils::instance();
    $utils->require_all_files('/inc/custom-post-types');
    $utils->require_all_files('/inc/taxonomies');
    $utils->require_all_files('/inc/shortcodes');
    $utils->require_all_files('/inc/ajax');
  }
}
?>