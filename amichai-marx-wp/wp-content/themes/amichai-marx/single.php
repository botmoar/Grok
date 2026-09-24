<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap am-article">
    <?php while (have_posts()) : the_post();
      $story_slug = rawurldecode((string) get_post_field('post_name', get_the_ID()));
      $is_stories = ($story_slug === 'סיפורי-משפחות');
      $cats = array_filter(get_the_category() ?: [], static function ($cat) {
          return $cat->name !== 'מאמרים';
      });
      ?>
      <article>
        <header class="am-article-head">
          <?php if ($cats && !$is_stories) : ?>
            <p class="am-meta"><?php
              $links = [];
              foreach ($cats as $cat) {
                  $links[] = '<a href="' . esc_url(get_category_link($cat)) . '">' . esc_html($cat->name) . '</a>';
              }
              echo implode(' · ', $links);
            ?></p>
          <?php endif; ?>
          <h1 class="am-page-title"><?php the_title(); ?></h1>
          <?php if (!$is_stories) : ?>
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j בF Y')); ?></time>
          <?php endif; ?>
        </header>
        <div class="am-prose"><?php the_content(); ?></div>
        <?php if ($is_stories) {
            amichai_story_index(get_the_ID());
        } ?>
      </article>
      <aside class="am-cta-band">
        <div>
          <h2>אפשר להתחיל בשיחה</h2>
          <p>054-2372417. בלי התחייבות.</p>
        </div>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>
      </aside>
      <?php
      if ($is_stories) {
          continue;
      }
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
