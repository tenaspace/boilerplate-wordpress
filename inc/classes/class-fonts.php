<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Fonts
{
  use Singleton;

  protected function __construct()
  {
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    add_action('wp_head', [$this, 'google_fonts'], 5);
    add_action('wp_head', [$this, 'local_fonts'], 5);
  }

  public function google_fonts()
  {
    $fonts_url = 'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';
    ?>
    <link rel="preload" href="<?php echo $fonts_url; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <noscript>
      <link href="<?php echo $fonts_url; ?>" rel="stylesheet" type="text/css" />
    </noscript>
    <?php
  }

  public function local_fonts()
  {

  }
}
?>