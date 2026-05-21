<?php
namespace TS;

class I18n
{
  public function __construct()
  {

  }

  public function default_language()
  {
    return app()->helpers->is_pll_activated() ? \pll_default_language() : explode('_', get_locale())[0];
  }

  public function languages_list()
  {
    return app()->helpers->is_pll_activated() ? \pll_languages_list() : [explode('_', get_locale())[0]];
  }

  public function get_current_language()
  {
    return app()->helpers->is_pll_activated() ? \pll_current_language() : explode('_', get_locale())[0];
  }

  public function translate(array $dictionaries)
  {
    $current_language = $this->get_current_language();
    if (!empty($dictionaries[$current_language])) {
      return $dictionaries[$current_language];
    } else {
      return null;
    }
  }
}