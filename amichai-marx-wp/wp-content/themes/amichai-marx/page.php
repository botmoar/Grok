<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap am-prose">
    <?php while (have_posts()) : the_post(); ?>
      <h1 class="am-page-title"><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</main>
<?php
get_footer();
