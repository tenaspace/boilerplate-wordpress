<?php
use TS\Inc\Dictionaries;

$dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'components.breadcrumb']);
// TODO
$default_list = [];
$list = isset($args['list']) ? $args['list'] : $default_list;
$separator = isset($args['separator']) && !empty($args['separator']) ? $args['separator'] : '/';
?>

<?php if (isset($list) && is_array($list) && sizeof((array) $list) > 0): ?>
  <nav aria-label="breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5 break-words text-sm text-zinc-500 sm:gap-2.5 dark:text-zinc-400">
      <li class="inline-flex items-center gap-1.5">
        <a class="transition-colors hover:text-zinc-950 dark:hover:text-zinc-50" href="/">
          <?php echo $dict('home'); ?>
        </a>
      </li>
      <?php foreach ($list as $key => $item): ?>
        <li role="presentation" aria-hidden="true" class="[&>svg]:size-3.5"><?php echo $separator; ?></li>
        <li class="inline-flex items-center gap-1.5">
          <?php if ($key < sizeof((array) $list) - 2): ?>
            <?php if (isset($item['link']) && !empty($item['link'])): ?>
              <a href="<?php echo $item['link']; ?>">
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
      <?php endforeach; ?>
    </ol>
  </nav>
<?php endif; ?>