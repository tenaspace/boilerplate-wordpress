<?php

add_shortcode('test', function () {
  ob_start();
  ?>
  <div>test</div>
  <?php
  $template = ob_get_contents();
  ob_end_clean();
  return $template;
});

?>