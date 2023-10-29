<?php
$content = $attributes['content'];
?>

<?php if ($content && !empty($content)): ?>
  <p>
    <?php echo __($content); ?>
  </p>
<?php endif; ?>