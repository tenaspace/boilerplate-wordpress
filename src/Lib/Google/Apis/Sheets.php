<?php
namespace TS\Lib\Google\Apis;

class Sheets
{
  public function __construct()
  {

  }

  public function service()
  {
    $client = new \Google\Client();
    $client->setAuthConfig(!empty($_ENV['GOOGLE_SERVICE_ACCOUNT_CREDENTIALS']) ? json_decode($_ENV['GOOGLE_SERVICE_ACCOUNT_CREDENTIALS'], true) : '');
    $client->addScope([\Google\Service\Sheets::SPREADSHEETS]);
    $service = new \Google\Service\Sheets($client);
    return $service;
  }
}