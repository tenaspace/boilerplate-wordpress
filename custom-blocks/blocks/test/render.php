<?php

$fields = get_fields();

?>

<?php if (isset($fields['text']) && !empty($fields['text'])): ?>
  <p class="p-5 bg-black text-white">
    <?php echo $fields['text']; ?>
  </p>
<?php endif; ?>