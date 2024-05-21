<?php
use TS\Inc\Dictionaries;

$dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'themes']);
?>
<div>
  <div>
    <button type='button' x-on:click="">
      <?php echo $dict('light'); ?>
    </button>
  </div>
  <div>
    <button type='button' x-on:click="">
      <?php echo $dict('dark'); ?>
    </button>
  </div>
  <div>
    <button type='button' x-on:click="">
      <?php echo $dict('system'); ?>
    </button>
  </div>
</div>