<?php
$defaults = [
  'list' => app()->lib->helpers->get_breadcrumb(),
  'separator' => '/',
];
$args = wp_parse_args($args, $defaults);
$has_list = is_array($args['list']) && !empty($args['list']) ? true : false;
?>
<nav aria-label="breadcrumb">
  <ol>
    <li>
      <?php if ($has_list): ?>
        <a href="<?php echo home_url(); ?>">
          <?php echo app()->i18n->translate([
            'en' => 'Home',
            'vi' => 'Trang chủ',
          ]); ?>
        </a>
      <?php else: ?>
        <span role="link" aria-disabled="true" aria-current="page">
          <?php echo app()->i18n->translate([
            'en' => 'Home',
            'vi' => 'Trang chủ',
          ]); ?>
        </span>
      <?php endif; ?>
    </li>
    <?php if ($has_list): ?>
      <li role="presentation" aria-hidden="true">
        <?php echo $args['separator']; ?>
      </li>
      <?php foreach ($args['list'] as $key => $item): ?>
        <li>
          <?php if ($key < sizeof((array) $args['list']) - 1): ?>
            <?php if (!empty($item['link'])): ?>
              <a href="<?php echo $item['link']; ?>">
                <?php echo $item['label']; ?>
              </a>
            <?php else: ?>
              <?php echo $item['label']; ?>
            <?php endif; ?>
          <?php else: ?>
            <span role="link" aria-disabled="true" aria-current="page">
              <?php echo $item['label']; ?>
            </span>
          <?php endif; ?>
        </li>
        <?php if ($key < sizeof((array) $args['list']) - 1): ?>
          <li role="presentation" aria-hidden="true">
            <?php echo $args['separator']; ?>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </ol>
</nav>