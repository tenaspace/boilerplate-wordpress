<?php
namespace TS\Shortcodes;

class Sample
{
  private $name = 'sample';

  public function __construct()
  {
    $this->hook();
  }

  public function hook()
  {
    add_shortcode($this->name, [$this, 'register_shortcode']);
  }

  public function register_shortcode()
  {
    ob_start();
    ?>
    <div>Sample</div>
    <?php
    $template = ob_get_contents();
    ob_end_clean();
    return $template;
  }
}