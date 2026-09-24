<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap am-article">
    <?php
    $related_posts = [];
    while (have_posts()) : the_post();
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
        <?php
        [$lead, $rest] = amichai_article_html();
        $is_service = amichai_is_service_hub(get_the_ID());
        ?>
        <div class="am-prose">
          <?php if ($lead !== '') : ?>
            <div class="am-article-lead"><?php echo $lead; ?></div>
          <?php endif; ?>
          <?php if ($is_service) {
              amichai_intro_cta();
          } ?>
          <?php if (!$is_stories) {
              amichai_inline_featured();
          } ?>
          <?php if ($rest !== '') {
              echo $rest;
          } ?>
        </div>
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
      if (!$is_stories) {
          $related = new WP_Query([
              'post_type' => 'post',
              'posts_per_page' => 2,
              'post__not_in' => [get_the_ID()],
              'category__in' => wp_get_post_categories(get_the_ID()),
              'ignore_sticky_posts' => true,
          ]);
          $related_posts = $related->posts;
          wp_reset_postdata();
      }
      ?>
    <?php endwhile; ?>
  </div>
  <?php if ($related_posts) : ?>
    <section class="am-wrap am-related-sec" aria-labelledby="am-related-title">
      <h2 id="am-related-title" class="am-related-title">עוד באותו נושא</h2>
      <div class="am-related-grid">
        <?php foreach ($related_posts as $related_post) : ?>
          <a class="am-mini" href="<?php echo esc_url(get_permalink($related_post)); ?>">
            <span class="am-mini-thumb">
              <?php echo get_the_post_thumbnail($related_post, 'medium', ['alt' => '']); ?>
            </span>
            <span>
              <strong><?php echo esc_html(get_the_title($related_post)); ?></strong>
              <time datetime="<?php echo esc_attr(get_the_date('c', $related_post)); ?>"><?php echo esc_html(get_the_date('j.n.Y', $related_post)); ?></time>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</main>
<?php
get_footer();
