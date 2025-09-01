<?php
namespace TS;

class Fonts
{
  private $google_fonts;
  private $local_fonts;

  public function __construct()
  {
    $this->google_fonts = 'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap';
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
    $this->hooks();
  }

  protected function hooks()
  {
    add_action('wp_head', [$this, 'fonts'], 5);
    add_action('admin_head', [$this, 'fonts'], 5);
  }

  public function fonts()
  {
    if (!empty($this->google_fonts)) {
      echo '<link rel="preload" href="' . $this->google_fonts . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" />';
      echo '<noscript><link href="' . $this->google_fonts . '" rel="stylesheet" type="text/css" /></noscript>';
    }
    if (is_array($this->local_fonts) && !empty($this->local_fonts)) {
      echo '<style>';
      foreach ($this->local_fonts as $local_font) {
        echo '@font-face {';
        echo !empty($local_font['family']) ? 'font-family: ' . $local_font['family'] . ';' : '';
        if (is_array($local_font['src']) && !empty($local_font['src'])) {
          echo 'src: ';
          foreach ($local_font['src'] as $key => $src) {
            if (!empty($src['url'])) {
              echo 'url(' . $src['url'] . ')';
              if (!empty($src['format'])) {
                echo ' format(\'' . $src['format'] . '\')';
              }
            }
            if ($key < count($local_font['src']) - 1) {
              echo ',';
            }
          }
          echo ';';
        }
        echo !empty($local_font['weight']) ? 'font-weight: ' . $local_font['weight'] . ';' : '';
        echo !empty($local_font['style']) ? 'font-style: ' . $local_font['style'] . ';' : '';
        echo !empty($local_font['display']) ? 'font-display: ' . $local_font['display'] . ';' : '';
        echo '}';
      }
      echo '</style>';
    }
  }
}