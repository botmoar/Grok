<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap">
    <h1 class="am-page-title"><?php echo is_home() ? 'מאמרים' : esc_html(wp_get_document_title()); ?></h1>
    <div class="am-posts">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php amichai_post_card(); ?>
      <?php endwhile; else : ?>
        <p>לא נמצאו תכנים.</p>
      <?php endif; ?>
    </div>
    <div class="am-pager"><?php the_posts_pagination(['mid_size' => 1]); ?></div>
  </div>
</main>
<?php
get_footer();
