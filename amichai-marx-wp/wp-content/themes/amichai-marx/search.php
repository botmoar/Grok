<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap">
    <h1 class="am-page-title">חיפוש: <?php echo esc_html(get_search_query()); ?></h1>
    <?php get_search_form(); ?>
    <div class="am-posts" style="margin-top:20px">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="am-post">
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
        </article>
      <?php endwhile; else : ?>
        <p>לא נמצאו תוצאות. אפשר לנסות מילה אחרת, או <a href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לפנות ישירות</a>.</p>
      <?php endif; ?>
    </div>
  </div>
</main>
<?php
get_footer();
