<?php

add_shortcode('hello_world', function () {
  ob_start();
  ?>
  <div>Hello world!</div>
  <?php
  $template = ob_get_contents();
  ob_end_clean();
  return $template;
});

?>