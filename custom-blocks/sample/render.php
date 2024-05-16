<?php
$fields = get_fields();
$defaults = [
  'text' => '',
];
$fields = wp_parse_args($fields, $defaults);
?>
<div x-data="customBlockSample($el)" x-on:click="handleClick">
  <?php echo $fields['text']; ?>
</div>