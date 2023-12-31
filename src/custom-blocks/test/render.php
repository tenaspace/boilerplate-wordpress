<?php

$content = $attributes['content'];

?>

<?php if ($content && !empty($content)): ?>
  <p>
    <?php echo $content; ?>
  </p>
<?php endif; ?>