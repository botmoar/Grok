<?php
defined('ABSPATH') || exit;
get_header();
if (amichai_is_mortgage_topic(get_queried_object_id())) {
    get_template_part('parts/mortgage-topic');
    get_footer();
    return;
}
if (amichai_is_service_hub(get_queried_object_id())) {
    get_template_part('parts/hub');
    get_footer();
    return;
}
?>
<main id="main" class="am-post-page">
  <?php
  while (have_posts()) : the_post();
      $post_id = get_the_ID();
      $story_slug = rawurldecode((string) get_post_field('post_name', $post_id));
      $is_stories = ($story_slug === 'סיפורי-משפחות');
      $cats = array_values(array_filter(get_the_category() ?: [], static function ($cat) {
          return $cat->name !== 'מאמרים';
      }));
      $words = count(preg_split('/\s+/u', wp_strip_all_tags(get_the_content(null, false)), -1, PREG_SPLIT_NO_EMPTY));
      $minutes = max(1, (int) round($words / 200));
      ?>
      <header class="am-page-hero am-post-hero">
        <div class="am-wrap am-article">
          <nav class="am-crumbs" aria-label="מיקום בעמוד">
            <a href="<?php echo esc_url(home_url('/')); ?>">עמוד הבית</a>
            <span aria-hidden="true">/</span>
            <a href="<?php echo esc_url(home_url('/מאמרים/')); ?>">מאמרים</a>
            <?php if ($cats && !$is_stories) : ?>
              <span aria-hidden="true">/</span>
              <a href="<?php echo esc_url(get_category_link($cats[0])); ?>"><?php echo esc_html($cats[0]->name); ?></a>
            <?php endif; ?>
          </nav>
          <h1 class="am-page-title"><?php the_title(); ?></h1>
          <?php if (!$is_stories) : ?>
            <p class="am-post-meta">
              <?php echo amichai_portrait_img('', [], 'avatar'); ?>
              <span>עמיחי מרקס</span>
              <span aria-hidden="true">·</span>
              <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j בF Y')); ?></time>
              <span aria-hidden="true">·</span>
              <span><?php echo esc_html($minutes . ' דקות קריאה'); ?></span>
            </p>
          <?php endif; ?>
        </div>
      </header>
      <div class="am-wrap am-article">
        <article>
          <?php [$lead, $rest] = amichai_article_html(); ?>
          <?php if (!$is_stories) {
              amichai_inline_featured();
          } ?>
          <div class="am-prose">
            <?php if ($lead !== '') : ?>
              <div class="am-article-lead"><?php echo $lead; ?></div>
            <?php endif; ?>
            <?php if ($rest !== '') {
                echo $rest;
            } ?>
          </div>
          <?php if ($is_stories) {
              amichai_story_index($post_id);
          } else { ?>
            <aside class="am-author" aria-label="על הכותב">
              <?php echo amichai_portrait_img('עמיחי מרקס', ['loading' => 'lazy'], 'avatar'); ?>
              <div>
                <p class="am-author-name">עמיחי מרקס</p>
                <p class="am-author-role">יועץ לכלכלת המשפחה ויועץ משכנתאות</p>
                <p>15 שנה בליווי משפחות ומעל 20 שנה בעולם הפיננסי. חבר בהתאחדות יועצי המשכנתאות בישראל.</p>
                <a href="<?php echo esc_url(home_url('/אודות/')); ?>">עוד עליי</a>
              </div>
            </aside>
          <?php } ?>
        </article>
      </div>
      <?php
      $related_posts = [];
      if (!$is_stories) {
          $related_posts = get_posts([
              'post_type' => 'post',
              'posts_per_page' => 2,
              'post__not_in' => [$post_id],
              'category__in' => $cats ? [(int) $cats[0]->term_id] : wp_get_post_categories($post_id),
              'ignore_sticky_posts' => true,
          ]);
          if (count($related_posts) < 2) {
              $related_posts = array_merge($related_posts, get_posts([
                  'post_type' => 'post',
                  'posts_per_page' => 2 - count($related_posts),
                  'post__not_in' => array_merge([$post_id], wp_list_pluck($related_posts, 'ID')),
                  'ignore_sticky_posts' => true,
              ]));
          }
      }
      if ($related_posts) : ?>
        <section class="am-post-related" aria-labelledby="am-related-title">
          <div class="am-wrap">
            <h2 id="am-related-title" class="am-related-title">עוד באותו נושא</h2>
            <div class="am-topic-grid am-topic-grid-2">
              <?php foreach ($related_posts as $related_post) {
                  amichai_topic_card($related_post);
              } ?>
            </div>
          </div>
        </section>
      <?php endif; ?>
  <?php endwhile; ?>
  <?php amichai_closing_cta(); ?>
</main>
<?php
get_footer();
