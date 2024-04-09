<?php

$fields = get_fields();

?>

<?php if (isset($fields['text']) && !empty($fields['text'])): ?>
  <?php echo $fields['text']; ?>
<?php endif; ?>