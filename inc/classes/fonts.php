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
    $this->local_fonts = [];
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
      ?>
      <link rel="preload" href="<?php echo $this->google_fonts; ?>" as="style"
        onload="this.onload=null;this.rel='stylesheet'" />
      <noscript>
        <link href="<?php echo $this->google_fonts; ?>" rel="stylesheet" type="text/css" />
      </noscript>
      <?php
    }

    /**
     * Local Fonts
     */

    if (isset($this->local_fonts) && is_array($this->local_fonts) && sizeof((array) $this->local_fonts) > 0) {
      ?>

      <?php
    }
  }
}
?>