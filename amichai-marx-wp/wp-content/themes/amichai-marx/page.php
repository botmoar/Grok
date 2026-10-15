<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <?php while (have_posts()) : the_post(); ?>
    <?php amichai_page_hero(get_the_title(), has_excerpt() ? get_the_excerpt() : ''); ?>
    <div class="am-wrap am-prose">
      <?php the_content(); ?>
    </div>
  <?php endwhile; ?>
</main>
<?php
get_footer();
