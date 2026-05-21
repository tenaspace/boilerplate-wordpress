<?php
namespace TS\Lib;

class DateFns
{
  private $date_fns = [
    'alt' => [
      'en' => 'MMMM D, YYYY',
      'vi' => 'D MMMM, YYYY',
    ],
    'value' => 'YYYY-MM-DD',
  ]; // SETUP: https://carbon.nesbot.com/

  public function __construct()
  {

  }

  public function get_current_date_fns(string $language = '')
  {
    $current_language = isset($language) && !empty($language) ? $language : app()->i18n->get_current_language();
    return [
      'language' => $current_language,
      'date_format' => [
        'alt' => $this->date_fns['alt'][$current_language],
        'value' => $this->date_fns['value'],
      ],
    ];
  }
}