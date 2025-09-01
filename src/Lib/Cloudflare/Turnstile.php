<?php
namespace TS\Lib\Cloudflare;

class Turnstile
{
  public function __construct()
  {

  }

  public function validate($token, $secret, $remoteip = null)
  {
    $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $data = [
      'secret' => $secret,
      'response' => $token
    ];
    if ($remoteip) {
      $data['remoteip'] = $remoteip;
    }
    $options = [
      'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
      ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    if ($response === FALSE) {
      return ['success' => false, 'error-codes' => ['internal-error']];
    }
    return json_decode($response, true);
  }

  public function error_message($error_code)
  {
    $message = '';
    switch ($error_code) {
      case 'missing-input-secret':
        $message = 'Secret parameter not provided. Ensure secret key is included.';
        break;
      case 'invalid-input-secret':
        $message = 'Secret key is invalid or expired. Check your secret key in the Cloudflare dashboard.';
        break;
      case 'missing-input-response';
        $message = 'Response parameter was not provided. Ensure token is included.';
        break;
      case 'invalid-input-response';
        $message = 'Token is invalid, malformed, or expired. User should retry the challenge.';
        break;
      case 'bad-request';
        $message = 'Request is malformed. Check request format and parameters.';
        break;
      case 'timeout-or-duplicate';
        $message = 'Token has already been validated. Each token can only be used once.';
        break;
      case 'internal-error';
        $message = 'Internal error occurred. Retry the request.';
        break;
      default:
        break;
    }
    return $message;
  }
}