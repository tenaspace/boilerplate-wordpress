<?php
use TS\Inc\Dictionaries;
use TS\Inc\Utils;

$dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'breadcrumb']);
$utils = Utils::instance();

$defaults = [
  'list' => $utils->get_breadcrumb(),
  'separator' => '/',
];
$args = wp_parse_args($args, $defaults);
$has_list = isset($args['list']) && is_array($args['list']) && sizeof((array) $args['list']) > 0 ? true : false;
?>
<nav aria-label="breadcrumb">
  <ol class="flex flex-wrap items-center gap-1.5 break-words text-sm text-zinc-500 sm:gap-2.5 dark:text-zinc-400">
    <li class="inline-flex items-center gap-1.5">
      <?php if ($has_list): ?>
        <a href="<?php echo home_url(); ?>" class="transition-colors hover:text-zinc-950 dark:hover:text-zinc-50">
          <?php echo $dict('home'); ?>
        </a>
      <?php else: ?>
        <span role="link" aria-disabled="true" aria-current="page" class="font-normal text-zinc-950 dark:text-zinc-50">
          <?php echo $dict('home'); ?>
        </span>
      <?php endif; ?>
    </li>
    <?php if ($has_list): ?>
      <li role="presentation" aria-hidden="true" class="[&>svg]:size-3.5">
        <?php echo $args['separator']; ?>
      </li>
      <?php foreach ($args['list'] as $key => $item): ?>
        <li class="inline-flex items-center gap-1.5">
          <?php if ($key < sizeof((array) $args['list']) - 1): ?>
            <?php if (isset($item['link']) && !empty($item['link'])): ?>
              <a href="<?php echo $item['link']; ?>" class="transition-colors hover:text-zinc-950 dark:hover:text-zinc-50">
                <?php echo $item['label']; ?>
              </a>
            <?php else: ?>
              <?php echo $item['label']; ?>
            <?php endif; ?>
          <?php else: ?>
            <span role="link" aria-disabled="true" aria-current="page" class="font-normal text-zinc-950 dark:text-zinc-50">
              <?php echo $item['label']; ?>
            </span>
          <?php endif; ?>
        </li>
        <?php if ($key < sizeof((array) $args['list']) - 1): ?>
          <li role="presentation" aria-hidden="true" class="[&>svg]:size-3.5">
            <?php echo $args['separator']; ?>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </ol>
</nav>