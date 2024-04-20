<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Dictionaries
{
  use Singleton;

  private $i18n;

  protected function __construct()
  {
    $this->i18n = [
      'en_US' => get_template_directory() . '/inc/dictionaries/en-us.php',
      'vi' => get_template_directory() . '/inc/dictionaries/vi.php',
    ];
  }

  private function create_i18n()
  {
    $result = [];
    foreach ($this->i18n as $locale => $path) {
      if (file_exists($path)) {
        $result[$locale] = require_once ($path);
      }
    }
    return $result;
  }

  private function get_i18n_by_locale($i18n, $locale = '')
  {
    $result = '';
    if (isset($i18n) && is_array($i18n) && sizeof((array) $i18n) > 0) {
      if (isset($locale) && !empty($locale)) {
        if (isset($i18n[$locale]) && is_array($i18n[$locale]) && sizeof((array) $i18n[$locale]) > 0) {
          $result = $i18n[$locale];
        }
      } else {
        $current_locale = get_locale();
        if (isset($i18n[$current_locale]) && is_array($i18n[$current_locale]) && sizeof((array) $i18n[$current_locale]) > 0) {
          $result = $i18n[$current_locale];
        }
      }
    }
    return $result;
  }

  private function get_i18n_by_scope($i18n, $scope = '')
  {
    $result = '';
    if (isset($i18n) && is_array($i18n) && sizeof((array) $i18n) > 0) {
      if (isset($scope) && !empty($scope)) {
        $scope_explode = explode('.', $scope);
        if (isset($scope_explode) && is_array($scope_explode) && sizeof((array) $scope_explode) > 0) {
          foreach ($scope_explode as $key => $scope_key) {
            if ($key === 0) {
              if (isset($i18n[$scope_key])) {
                $result = $i18n[$scope_key];
              } else {
                $result = '';
              }
            } else {
              if (isset($result[$scope_key])) {
                $result = $result[$scope_key];
              } else {
                $result = '';
              }
            }
          }
        }
      } else {
        $result = $i18n;
      }
    }
    return $result;
  }

  final public function get_scoped_i18n($args = [])
  {
    $locale = isset($args['locale']) ? $args['locale'] : '';
    $scope = isset($args['scope']) ? $args['scope'] : '';
    $i18n = $this->get_i18n_by_scope($this->get_i18n_by_locale($this->create_i18n(), $locale), $scope);
    return function ($scope = '') use ($i18n) {
      if (isset ($scope) && !empty ($scope)) {
        return $this->get_i18n_by_scope($i18n, $scope);
      } else {
        return $i18n;
      }
    };
  }
}
?>