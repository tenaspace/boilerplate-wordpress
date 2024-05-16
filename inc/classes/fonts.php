<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Fonts
{
  use Singleton;

  private $google_fonts;
  private $local_fonts;

  protected function __construct()
  {
    $this->google_fonts = 'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';
    // $this->local_fonts = [
    //   [
    //     'family' => '"Sample"',
    //     'src' => [
    //       ['url' => PUBLIC_URI . '/assets/fonts/sample.woff', 'format' => 'woff'],
    //       ['url' => PUBLIC_URI . '/assets/fonts/sample.woff2', 'format' => 'woff2']
    //     ],
    //     'weight' => '400',
    //     'style' => 'normal',
    //     'display' => 'swap',
    //   ],
    // ];
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    add_action('wp_head', [$this, 'fonts'], 5);
    add_action('admin_head', [$this, 'fonts'], 5);
  }

  public function fonts()
  {
    /**
     * Google Fonts
     */

    if (isset($this->google_fonts) && $this->google_fonts) {
      echo '<link rel="preload" href="' . $this->google_fonts . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" />';
      echo '<noscript><link href="' . $this->google_fonts . '" rel="stylesheet" type="text/css" /></noscript>';
    }

    /**
     * Local Fonts
     */

    if (isset($this->local_fonts) && is_array($this->local_fonts) && sizeof((array) $this->local_fonts) > 0) {
      echo '<style>';
      foreach ($this->local_fonts as $local_font) {
        echo '@font-face {';
        echo isset($local_font['family']) && $local_font['family'] ? 'font-family: ' . $local_font['family'] . ';' : '';
        if (isset($local_font['src']) && is_array($local_font['src']) && sizeof((array) $local_font['src']) > 0) {
          echo 'src: ';
          foreach ($local_font['src'] as $key => $src) {
            if (isset($src['url']) && $src['url']) {
              echo 'url(' . $src['url'] . ')';
              if (isset($src['format']) && $src['format']) {
                echo ' format(\'' . $src['format'] . '\')';
              }
            }
            if ($key < sizeof((array) $local_font['src']) - 1) {
              echo ',';
            }
          }
          echo ';';
        }
        echo isset($local_font['weight']) && $local_font['weight'] ? 'font-weight: ' . $local_font['weight'] . ';' : '';
        echo isset($local_font['style']) && $local_font['style'] ? 'font-style: ' . $local_font['style'] . ';' : '';
        echo isset($local_font['display']) && $local_font['display'] ? 'font-display: ' . $local_font['display'] . ';' : '';
        echo '}';
      }
      echo '</style>';
    }
  }
}
?>