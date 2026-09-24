<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap">
    <h1 class="am-page-title"><?php the_archive_title(); ?></h1>
    <?php the_archive_description('<div class="am-prose">', '</div>'); ?>
    <div class="am-posts">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="am-post">
          <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j.n.Y')); ?></time>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
        </article>
      <?php endwhile; else : ?>
        <p>אין עדיין פריטים בקטגוריה הזו.</p>
      <?php endif; ?>
    </div>
    <div class="am-pager"><?php the_posts_pagination(['mid_size' => 1]); ?></div>
  </div>
</main>
<?php
get_footer();
