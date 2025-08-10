<?php
get_header();
$queried_object = get_queried_object();
$fields = get_fields($queried_object->taxonomy . '_' . $queried_object->term_id);
?>

<div class="<?php echo app()->utils->cn('h-feed'); ?>">
  <header>
    <?php get_template_part('components/breadcrumb'); ?>
    <?php if (isset($fields['featured_image']['id'])): ?>
      <?php echo wp_get_attachment_image($fields['featured_image']['id'], 'large', false, [
        'class' => app()->utils->cn('u-featured'),
        'alt' => isset($fields['featured_image']['alt']) && !empty($fields['featured_image']['alt']) ? $fields['featured_image']['alt'] : get_the_archive_title(),
      ]); ?>
    <?php endif; ?>
    <?php if (is_search()): ?>
      <div>
        <?php echo app()->i18n->translate([
          'en' => 'Search for keywords',
          'vi' => 'Tìm kiếm cho từ khóa',
        ]); ?>: <?php echo esc_html(get_search_query()); ?>
      </div>
    <?php else: ?>
      <h1 class="<?php echo app()->utils->cn('p-name'); ?>">
        <?php echo get_the_archive_title(); ?>
      </h1>
    <?php endif; ?>
    <div>
      <?php echo get_the_archive_description(); ?>
    </div>
  </header>
  <?php if (have_posts()): ?>
    <div>
      <?php while (have_posts()):
        the_post(); ?>
        <div>
          <article class="<?php echo app()->utils->cn('h-entry'); ?>">
            <a href="<?php echo get_the_permalink(get_the_ID()); ?>" title="<?php echo get_the_title(get_the_ID()); ?>"
              class="<?php echo app()->utils->cn('u-url'); ?>">
              <header>
                <?php if (has_post_thumbnail(get_the_ID())): ?>
                  <?php $alt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true); ?>
                  <?php echo get_the_post_thumbnail(get_the_ID(), 'large', [
                    'alt' => isset($alt) && !empty($alt) ? $alt : get_the_title(get_the_ID()),
                    'class' => app()->utils->cn('u-featured'),
                  ]); ?>
                <?php endif; ?>
                <h2 class="<?php echo app()->utils->cn('p-name'); ?>">
                  <?php echo get_the_title(get_the_ID()); ?>
                </h2>
                <p>
                  <span class="p-author h-card">
                    <?php echo get_the_author(); ?>
                  </span>
                  <time dateTime="<?php echo get_the_date('c', get_the_ID()); ?>"
                    class="<?php echo app()->utils->cn('dt-published'); ?>">
                    <?php echo get_the_date(DATE_FORMAT, get_the_ID()); ?>
                  </time>
                  <time dateTime="<?php echo get_the_modified_date('c', get_the_ID()); ?>"
                    class="<?php echo app()->utils->cn('dt-updated'); ?>">
                    <?php echo get_the_modified_date(DATE_FORMAT, get_the_ID()); ?>
                  </time>
                </p>
              </header>
              <div class="<?php echo app()->utils->cn('e-content'); ?>">
                <p>
                  <?php echo get_the_excerpt(get_the_ID()); ?>
                </p>
              </div>
              <footer></footer>
            </a>
          </article>
        </div>
      <?php endwhile;
      wp_reset_postdata(); ?>
    </div>
  <?php endif; ?>
  <footer>
    <?php /** // TODO: Load more */ ?>
  </footer>
</div>

<?php get_footer(); ?>