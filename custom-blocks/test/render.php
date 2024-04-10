<?php

$fields = get_fields();
$text = $fields['text'];

?>

<?php if ($text): ?>
  <p x-data="customBlockTest('<?php echo $text; ?>')" x-on:click="onClick">
    <?php echo $text; ?>
  </p>
<?php endif; ?>