<?php
get_header();
$categories = get_the_category(get_the_ID());
$tags = get_the_tags(get_the_ID());
?>

<article class="<?php echo app()->lib->utils->cn('h-entry'); ?>">
  <header>
    <?php get_template_part('components/ui/breadcrumb'); ?>
    <?php if (has_post_thumbnail(get_the_ID())): ?>
      <?php $alt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true); ?>
      <?php echo get_the_post_thumbnail(get_the_ID(), 'large', [
        'alt' => !empty($alt) ? $alt : get_the_title(get_the_ID()),
        'class' => app()->lib->utils->cn('u-featured'),
      ]); ?>
    <?php endif; ?>
    <h1 class="<?php echo app()->lib->utils->cn('p-name'); ?>">
      <?php echo get_the_title(get_the_ID()); ?>
    </h1>
  </header>
  <?php if (have_posts()): ?>
    <div class="<?php echo app()->lib->utils->cn('e-content'); ?>">
      <?php while (have_posts()):
        the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile;
      wp_reset_postdata(); ?>
    </div>
  <?php endif; ?>
  <footer>
    <?php if (is_array($categories) && !empty($categories)): ?>
      <p>
        <?php foreach ($categories as $category): ?>
          <a href="<?php echo get_term_link($category); ?>" class="<?php echo app()->lib->utils->cn('p-category'); ?>">
            <?php echo $category->name; ?>
          </a>
        <?php endforeach; ?>
      </p>
    <?php endif; ?>
    <?php if (is_array($tags) && !empty($tags)): ?>
      <p>
        <?php foreach ($tags as $tag): ?>
          <a href="<?php echo get_term_link($tag); ?>" rel="tag" class="<?php echo app()->lib->utils->cn('p-category'); ?>">
            <?php echo $tag->name; ?>
          </a>
        <?php endforeach; ?>
      </p>
    <?php endif; ?>
    <p>
      <span class="p-author h-card">
        <?php echo get_the_author(); ?>
      </span>
      <time dateTime="<?php echo get_the_date('c', get_the_ID()); ?>"
        class="<?php echo app()->lib->utils->cn('dt-published'); ?>">
        <?php echo get_the_date(DATE_FORMAT, get_the_ID()); ?>
      </time>
      <time dateTime="<?php echo get_the_modified_date('c', get_the_ID()); ?>"
        class="<?php echo app()->lib->utils->cn('dt-updated'); ?>">
        <?php echo get_the_modified_date(DATE_FORMAT, get_the_ID()); ?>
      </time>
    </p>
  </footer>
</article>

<?php get_footer(); ?>