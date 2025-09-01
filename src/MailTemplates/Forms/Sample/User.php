<?php
namespace TS\MailTemplates\Forms\Sample;

class User
{
  public function __construct()
  {

  }

  public function html(array $data)
  {
    return app()->i18n->translate([
      'en' => "
        <div>Thank you.</div>
      ",
      'vi' => "
        <div>Cảm ơn.</div>
      ",
    ]);
  }
}