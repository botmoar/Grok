<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap">
    <h1 class="am-page-title"><?php echo is_home() ? 'מאמרים' : esc_html(wp_get_document_title()); ?></h1>
    <div class="am-posts">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="am-post">
          <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j.n.Y')); ?></time>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
        </article>
      <?php endwhile; else : ?>
        <p>לא נמצאו תכנים.</p>
      <?php endif; ?>
    </div>
    <div class="am-pager"><?php the_posts_pagination(['mid_size' => 1]); ?></div>
  </div>
</main>
<?php
get_footer();
