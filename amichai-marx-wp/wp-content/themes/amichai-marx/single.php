<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap am-article">
    <?php while (have_posts()) : the_post(); ?>
      <article>
        <header class="am-article-head">
          <p class="am-meta"><?php the_category(' · '); ?></p>
          <h1 class="am-page-title"><?php the_title(); ?></h1>
          <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j בF Y')); ?></time>
        </header>
        <div class="am-prose"><?php the_content(); ?></div>
      </article>
      <aside class="am-cta-band">
        <div>
          <h2>לבדוק את זה על הבית שלכם</h2>
          <p>שיחת ייעוץ עם עמיחי מרקס. 054-2372417.</p>
        </div>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>
      </aside>
      <?php
      $related = new WP_Query([
          'post_type' => 'post',
          'posts_per_page' => 3,
          'post__not_in' => [get_the_ID()],
          'category__in' => wp_get_post_categories(get_the_ID()),
      ]);
      if ($related->have_posts()) :
          echo '<h2 class="am-related-title">עוד באותו נושא</h2><ul class="am-related">';
          while ($related->have_posts()) :
              $related->the_post();
              echo '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
          endwhile;
          echo '</ul>';
          wp_reset_postdata();
      endif;
      ?>
    <?php endwhile; ?>
  </div>
</main>
<?php
get_footer();
