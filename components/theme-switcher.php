<?php
use TS\Inc\Dictionaries;

$dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'themes']);
?>
<div>
  <div>
    <button x-data type='button' x-on:click="$store.theme.setTheme('light')">
      <?php echo $dict('light'); ?>
    </button>
  </div>
  <div>
    <button x-data type='button' x-on:click="$store.theme.setTheme('dark')">
      <?php echo $dict('dark'); ?>
    </button>
  </div>
  <div>
    <button x-data type='button' x-on:click="$store.theme.setTheme('system')">
      <?php echo $dict('system'); ?>
    </button>
  </div>
</div>