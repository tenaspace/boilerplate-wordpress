<?php
$fields = get_fields();
$text = isset($fields['text']) && !empty($fields['text']) ? $fields['text'] : '';
?>

<?php if ($text): ?>
  <div x-data="customBlockSample($el)" x-on:click="handleClick">
    <?php echo $text; ?>
  </div>
<?php endif; ?>