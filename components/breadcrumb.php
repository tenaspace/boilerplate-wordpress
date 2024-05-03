<?php
use TS\Inc\Utils;

$utils = Utils::instance();

$defaults = [
  'list' => $utils->get_breadcrumb(),
  'separator' => '/',
];
$args = wp_parse_args($args, $defaults);
?>

<?php if (isset($args['list']) && is_array($args['list']) && sizeof((array) $args['list']) > 0): ?>
  <nav aria-label="breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5 break-words text-sm text-zinc-500 sm:gap-2.5 dark:text-zinc-400">
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
    </ol>
  </nav>
<?php endif; ?>

<?php /*
function custom_breadcrumbs($args = array())
{
  // Default arguments
  $defaults = array(
    'separator' => ' / ',
    'home_text' => 'Home',
    'show_current' => true,
    'show_home_link' => true,
    'home_link_class' => 'breadcrumb-home',
    'breadcrumb_class' => 'breadcrumbs',
    'current_class' => 'current',
    'echo' => true,
  );

  // Merge default arguments with user-supplied arguments
  $args = wp_parse_args($args, $defaults);

  // Start breadcrumb output
  $breadcrumb_output = '<nav class="' . esc_attr($args['breadcrumb_class']) . '">';

  // Home link
  if ($args['show_home_link']) {
    $breadcrumb_output .= '<a class="' . esc_attr($args['home_link_class']) . '" href="' . esc_url(home_url('/')) . '">' . esc_html($args['home_text']) . '</a>' . $args['separator'];
  }

  // Generate breadcrumbs based on current page
  if (is_single()) {
    // Single post
    $post = get_queried_object();
    $post_type = get_post_type($post);
    if ($post_type === 'post') {
      // For default post type
      $categories = get_the_category();
      if ($categories) {
        foreach ($categories as $category) {
          $breadcrumb_output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>' . $args['separator'];
        }
      }
    } else {
      // For custom post types
      $taxonomy_objects = get_object_taxonomies($post_type);
      if ($taxonomy_objects) {
        $taxonomy = $taxonomy_objects[0]; // Assuming only one hierarchical taxonomy is used
        $terms = get_the_terms($post->ID, $taxonomy);
        if ($terms && !is_wp_error($terms)) {
          $term = array_shift($terms);
          $ancestors = get_ancestors($term->term_id, $taxonomy, 'taxonomy');
          $ancestors = array_reverse($ancestors);
          foreach ($ancestors as $ancestor_id) {
            $ancestor = get_term($ancestor_id, $taxonomy);
            $breadcrumb_output .= '<a href="' . esc_url(get_term_link($ancestor->term_id)) . '">' . esc_html($ancestor->name) . '</a>' . $args['separator'];
          }
          $breadcrumb_output .= '<span class="' . esc_attr($args['current_class']) . '">' . esc_html($term->name) . '</span>';
        }
      }
    }
    if ($args['show_current']) {
      $breadcrumb_output .= $args['separator'] . '<span class="' . esc_attr($args['current_class']) . '">' . get_the_title() . '</span>';
    }
  } elseif (is_page()) {
    // Page
    if ($args['show_current']) {
      $breadcrumb_output .= '<span class="' . esc_attr($args['current_class']) . '">' . get_the_title() . '</span>';
    }
  } elseif (is_category()) {
    // Category archive
    $category = get_queried_object();
    if ($args['show_current']) {
      $breadcrumb_output .= '<span class="' . esc_attr($args['current_class']) . '">' . esc_html($category->name) . '</span>';
    }
  } elseif (is_tax()) {
    // Taxonomy archive
    $term = get_queried_object();
    if ($term->parent) {
      $ancestors = get_ancestors($term->term_id, $term->taxonomy);
      $ancestors = array_reverse($ancestors);
      foreach ($ancestors as $ancestor_id) {
        $ancestor = get_term($ancestor_id, $term->taxonomy);
        $breadcrumb_output .= '<a href="' . esc_url(get_term_link($ancestor->term_id)) . '">' . esc_html($ancestor->name) . '</a>' . $args['separator'];
      }
    }
    $breadcrumb_output .= '<span class="' . esc_attr($args['current_class']) . '">' . esc_html($term->name) . '</span>';
  } elseif (is_archive() && !is_category()) {
    // Other archives (e.g., tag, author)
    if ($args['show_current']) {
      $breadcrumb_output .= '<span class="' . esc_attr($args['current_class']) . '">Archives</span>';
    }
  } elseif (is_search()) {
    // Search results
    if ($args['show_current']) {
      $breadcrumb_output .= '<span class="' . esc_attr($args['current_class']) . '">Search results for "' . esc_html(get_search_query()) . '"</span>';
    }
  } elseif (is_404()) {
    // 404 error page
    if ($args['show_current']) {
      $breadcrumb_output .= '<span class="' . esc_attr($args['current_class']) . '">404 Not Found</span>';
    }
  }

  // End breadcrumb output
  $breadcrumb_output .= '</nav>';

  // Output or return breadcrumb
  if ($args['echo']) {
    echo $breadcrumb_output;
  } else {
    return $breadcrumb_output;
  }
}
*/ ?>