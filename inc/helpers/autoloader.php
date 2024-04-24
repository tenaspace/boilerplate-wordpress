<?php
namespace TS\Inc\Helpers;

function autoloader($resource = '')
{
  $resource_path = false;
  $namespace_root = 'TS\\';
  $resource = trim($resource, '\\');

  if (empty($resource) || strpos($resource, '\\') === false || strpos($resource, $namespace_root) !== 0) {
    return;
  }

  $resource = str_replace($namespace_root, '', $resource);

  $path = explode(
    '\\',
    str_replace('_', '-', strtolower($resource))
  );

  if (empty($path[0]) || empty($path[1])) {
    return;
  }

  $directory = '';
  $file_name = '';

  if ($path[0] === 'inc') {
    switch ($path[1]) {
      case 'traits':
        $directory = 'inc/traits';
        $file_name = sprintf('%s', trim(strtolower($path[2])));
        break;
      case 'init':
        $directory = 'inc';
        $file_name = sprintf('%s', trim(strtolower($path[1])));
        break;
      default:
        $directory = 'inc/classes';
        $file_name = sprintf('%s', trim(strtolower($path[1])));
        break;
    }
    $resource_path = sprintf('%s/%s/%s.php', get_template_directory(), $directory, $file_name);
  }

  $is_valid_file = validate_file($resource_path);

  if (!empty($resource_path) && file_exists($resource_path) && ($is_valid_file === 0 || $is_valid_file === 2)) {
    require_once ($resource_path); // phpcs:ignore
  }
}

spl_autoload_register('\TS\Inc\Helpers\autoloader');
?>