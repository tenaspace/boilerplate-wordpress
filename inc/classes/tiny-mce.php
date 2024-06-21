<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class Tiny_Mce
{
  use Singleton;

  private $buttons;
  private $buttons_2;
  private $plugins;

  protected function __construct()
  {
    $this->buttons = [
      'mce_sample_button',
    ];
    $this->buttons_2 = [];
    $this->plugins = [
      'mce_sample' => get_template_directory_uri() . '/inc/tiny-mce/sample.js' . '?ver=' . '1.0.0',
    ];
    $this->set_hooks();
  }

  protected function set_hooks()
  {
    add_filter('tiny_mce_before_init', [$this, 'before_init']);
    add_filter('mce_buttons', [$this, 'buttons']);
    add_filter('mce_buttons_2', [$this, 'buttons_2']);
    add_filter('mce_external_plugins', [$this, 'external_plugins']);
  }

  public function before_init($mce_init)
  {
    $mce_init['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre';
    return $mce_init;
  }

  public function buttons($buttons)
  {
    $buttons = array_merge($buttons, $this->buttons);
    return $buttons;
  }

  public function buttons_2($buttons)
  {
    $buttons = array_merge($buttons, $this->buttons_2);
    return $buttons;
  }

  public function external_plugins($plugins)
  {
    $plugins = array_merge($plugins, $this->plugins);
    return $plugins;
  }
}
?>