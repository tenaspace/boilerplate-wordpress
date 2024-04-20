<?php
$fields = get_fields();
$text = $fields['text'];
?>

<?php if ($text): ?>
  <p x-data="customBlockSample($el)" x-on:click="handleClick">
    <?php echo $text; ?>
  </p>
<?php endif; ?>