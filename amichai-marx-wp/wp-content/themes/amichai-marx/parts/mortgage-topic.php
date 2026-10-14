<?php
defined('ABSPATH') || exit;

the_post();
$slug = rawurldecode((string) get_post_field('post_name', get_the_ID()));
$topic = amichai_mortgage_topic($slug);
$groups = amichai_mortgage_groups();
$group = $groups[$topic['group']];
$faq = amichai_post_faq(get_the_ID());
$excerpt = has_excerpt() ? get_the_excerpt() : '';
$arrow = '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="M14 6 8 12l6 6"/></svg>';
$siblings = array_values(array_filter($group['items'], static fn ($item) => $item['slug'] !== $slug));
?>
<main id="main" class="am-mt">
  <section class="am-mt-hero">
    <div class="am-wrap am-mt-hero-grid">
      <div class="am-mt-hero-copy">
        <nav class="am-crumbs" aria-label="מיקום בעמוד">
          <a href="<?php echo esc_url(home_url('/')); ?>">עמוד הבית</a>
          <span aria-hidden="true">/</span>
          <a href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/')); ?>">משכנתאות</a>
          <span aria-hidden="true">/</span>
          <span><?php echo esc_html($topic['label']); ?></span>
        </nav>
        <p class="am-kicker am-kicker-light"><?php echo esc_html($group['title']); ?></p>
        <h1 class="am-mt-title"><?php the_title(); ?></h1>
        <?php if ($excerpt !== '') : ?>
          <p class="am-mt-lead"><?php echo esc_html($excerpt); ?></p>
        <?php endif; ?>
        <div class="am-actions">
          <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לשיחת ייעוץ משכנתא <?php echo $arrow; ?></a>
          <?php amichai_whatsapp_button('am-btn am-btn-on-dark am-btn-wa'); ?>
        </div>
        <?php amichai_mortgage_trust_line(); ?>
      </div>
      <nav class="am-mt-siblings" aria-label="<?php echo esc_attr('עוד ב' . $group['title']); ?>">
        <span class="am-mmap-icon"><?php echo amichai_mortgage_icon($group['icon']); ?></span>
        <p>עוד ב<?php echo esc_html($group['title']); ?></p>
        <ul>
          <?php foreach ($siblings as $item) : ?>
            <li><a href="<?php echo esc_url(home_url('/' . $item['slug'] . '/')); ?>"><?php echo esc_html($item['label']); ?></a></li>
          <?php endforeach; ?>
        </ul>
        <a class="am-mt-all" href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/#mortgage-' . $topic['group'])); ?>">כל נושאי המשכנתא</a>
      </nav>
    </div>
  </section>

  <div class="am-wrap am-hub-body am-mt-body">
    <article class="am-prose am-hub-prose am-mt-prose">
      <?php the_content(); ?>
    </article>
    <aside class="am-hub-aside">
      <div class="am-aside-card">
        <div class="am-aside-who">
          <?php amichai_portrait('am-aside-photo'); ?>
          <p><strong>עמיחי מרקס</strong><span>יועץ משכנתאות ויועץ לכלכלת המשפחה</span></p>
        </div>
        <p class="am-aside-text">שיחת היכרות, בלי התחייבות. בונים את המשכנתא מתוך התמונה המלאה של הבית, וממשיכים בליווי צמוד.</p>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחה</a>
        <a class="am-aside-phone" href="tel:054-2372417">או בטלפון <span dir="ltr">054-2372417</span></a>
      </div>
      <nav class="am-aside-nav am-aside-mnav" aria-label="נושאי משכנתא">
        <?php foreach ($groups as $g) : ?>
          <p><?php echo esc_html($g['title']); ?></p>
          <ul>
            <?php foreach ($g['items'] as $item) : ?>
              <li><a href="<?php echo esc_url(home_url('/' . $item['slug'] . '/')); ?>"<?php echo $item['slug'] === $slug ? ' aria-current="page"' : ''; ?>><?php echo esc_html($item['label']); ?></a></li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
      </nav>
    </aside>
  </div>

  <?php if ($faq) : ?>
    <section class="am-faq-sec am-mt-faq" aria-labelledby="am-mt-faq-title">
      <div class="am-wrap am-faq">
        <p class="am-kicker">שאלות ותשובות</p>
        <h2 id="am-mt-faq-title">שאלות נפוצות</h2>
        <?php foreach ($faq as $row) : ?>
          <details>
            <summary><?php echo esc_html($row['q']); ?></summary>
            <p><?php echo esc_html($row['a']); ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <?php
  $related = [];
  foreach ((array) json_decode((string) get_post_meta(get_the_ID(), '_amichai_related', true), true) as $related_slug) {
      $post = is_string($related_slug) ? amichai_post_by_slug($related_slug) : null;
      if ($post) {
          $related[] = $post;
      }
  }
  if ($related) :
      ?>
    <section class="am-hub-related" aria-labelledby="am-mt-related-title">
      <div class="am-wrap">
        <h2 id="am-mt-related-title" class="am-related-title">מכלכלת המשפחה: קשור לנושא</h2>
        <div class="am-topic-grid">
          <?php foreach ($related as $post) {
              amichai_topic_card($post);
          } ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php amichai_closing_cta('בודקים את המשכנתא יחד', 'שיחת היכרות, בלי התחייבות. משם תוכנית, השוואת הצעות, וליווי צמוד לאורך הדרך.'); ?>
</main>
