<?php
namespace TS\MailTemplates\Forms\Sample;

class Admin
{
  public function __construct()
  {

  }

  public function html(array $data)
  {
    return app()->i18n->translate([
      'en' => "
        <div>{$data['fullName']}</div>
        <div>{$data['email']}</div>
        <div>{$data['telephone']}</div>
        <div>{$data['message']}</div>
      ",
      'vi' => "
        <div>{$data['fullName']}</div>
        <div>{$data['email']}</div>
        <div>{$data['telephone']}</div>
        <div>{$data['message']}</div>
      ",
    ]);
  }
}