<?php
$defaults = [
  'text' => '',
];
$args = wp_parse_args($args, $defaults);
?>
<div x-data="dynamicBlockSample($el)" x-on:click="handleClick">
  <?php echo $args['text']; ?>
</div>