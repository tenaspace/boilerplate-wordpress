<?php
namespace TS;

class I18n
{
  public function __construct()
  {

  }

  public function translate(array $dictionaries)
  {
    $current_lang = \pll_current_language();
    if (!empty($dictionaries[$current_lang])) {
      return $dictionaries[$current_lang];
    } else {
      return null;
    }
  }
}