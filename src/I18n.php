<?php
namespace TS;

class I18n
{
  public function __construct()
  {

  }

  public function default_language(string $field = 'slug')
  {
    return app()->lib->helpers->is_pll_activated() ? \pll_default_language($field) : explode('_', get_locale())[0];
  }

  public function languages_list($args = [])
  {
    return app()->lib->helpers->is_pll_activated() ? \pll_languages_list($args) : [explode('_', get_locale())[0]];
  }

  public function current_language(string $field = 'slug')
  {
    return app()->lib->helpers->is_pll_activated() ? \pll_current_language($field) : explode('_', get_locale())[0];
  }

  public function translate(array $dictionaries)
  {
    $current_language = $this->current_language();
    if (!empty($dictionaries[$current_language])) {
      return $dictionaries[$current_language];
    } else {
      return null;
    }
  }
}