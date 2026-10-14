<?php
defined('ABSPATH') || exit;

the_post();
$slug = rawurldecode((string) get_post_field('post_name', get_the_ID()));
$profile = amichai_hub_profile($slug);
[$lead, $rest] = amichai_article_html();
$excerpt = has_excerpt() ? get_the_excerpt() : '';
$arrow = '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="M14 6 8 12l6 6"/></svg>';
?>
<main id="main" class="am-hub am-hub-<?php echo esc_attr($profile['tone']); ?>">
  <section class="am-hub-hero">
    <div class="am-wrap am-hub-hero-grid">
      <div class="am-hub-hero-copy">
        <nav class="am-crumbs" aria-label="מיקום בעמוד">
          <a href="<?php echo esc_url(home_url('/')); ?>">עמוד הבית</a>
          <span aria-hidden="true">/</span>
          <span><?php echo esc_html($profile['kicker']); ?></span>
        </nav>
        <h1 class="am-hub-title"><?php the_title(); ?></h1>
        <?php if ($excerpt !== '') : ?>
          <p class="am-hub-lead"><?php echo esc_html($excerpt); ?></p>
        <?php endif; ?>
        <div class="am-actions">
          <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת היכרות <?php echo $arrow; ?></a>
          <?php amichai_whatsapp_button('am-btn am-btn-ghost am-btn-wa'); ?>
        </div>
      </div>
      <div class="am-hub-visual"<?php echo !empty($profile['cert']) ? ' id="mortgage-cert"' : ''; ?>>
        <?php if (!empty($profile['cert'])) : ?>
          <?php amichai_cert_figure($profile['cert'], 'am-cert-wide am-cert-on-dark'); ?>
        <?php elseif (has_post_thumbnail()) : ?>
          <figure class="am-hub-photo"><?php the_post_thumbnail('large', ['alt' => '', 'loading' => 'eager']); ?></figure>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php if ($profile['highlights']) : ?>
    <section class="am-hub-highlights" aria-label="עיקרי הדברים">
      <div class="am-wrap">
        <ul class="am-highlights">
          <?php foreach ($profile['highlights'] as [$title, $text]) : ?>
            <li><strong><?php echo esc_html($title); ?></strong><span><?php echo esc_html($text); ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  <?php endif; ?>

  <?php if ($slug === 'דיור-ומשכנתאות') : ?>
    <section class="am-mtopics am-mtopics-hub" aria-labelledby="am-mtopics-title">
      <div class="am-wrap">
        <header class="am-sec-head am-sec-head-start">
          <p class="am-kicker">נושאי המשכנתא</p>
          <h2 id="am-mtopics-title">מה מביא אתכם? מתחילים מהמצב שלכם</h2>
          <p>שלושה עשר נושאים, מקובצים לפי השלב בחיים. בכל אחד: למי הוא מתאים, איפה נתקעים, איך מלווים צעד אחר צעד, ומה להכין לפגישה.</p>
        </header>
        <?php amichai_mortgage_map(); ?>
      </div>
    </section>
  <?php endif; ?>

  <div class="am-wrap am-hub-body">
    <article class="am-prose am-hub-prose">
      <?php
      echo $lead;
      echo $rest;
      ?>
    </article>
    <aside class="am-hub-aside">
      <div class="am-aside-card">
        <div class="am-aside-who">
          <?php amichai_portrait('am-aside-photo'); ?>
          <p><strong>עמיחי מרקס</strong><span>יועץ לכלכלת המשפחה ויועץ משכנתאות</span></p>
        </div>
        <p class="am-aside-text">שיחת היכרות קצרה, בלי התחייבות. משם בונים תוכנית, וממשיכים יחד בליווי צמוד לאורך הדרך.</p>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת היכרות</a>
        <a class="am-aside-phone" href="tel:054-2372417">או בטלפון <span dir="ltr">054-2372417</span></a>
      </div>
      <nav class="am-aside-nav" aria-label="תחומי ייעוץ">
        <p>תחומי ייעוץ</p>
        <?php amichai_render_flat_links(array_values(array_filter(amichai_footer_service_links(), static fn ($l) => ($l['slug'] ?? '') !== $slug))); ?>
      </nav>
    </aside>
  </div>

  <?php if ($slug === 'דיור-ומשכנתאות') : ?>
    <section class="am-hub-stories" aria-labelledby="am-hub-stories-title">
      <div class="am-wrap">
        <header class="am-sec-head am-sec-head-start">
          <p class="am-kicker">משפחות שליוויתי במשכנתא</p>
          <h2 id="am-hub-stories-title">מהשאלה «אפשר בכלל?» ועד בית משלנו</h2>
        </header>
        <div class="am-quote-grid">
          <figure class="am-quote">
            <blockquote><p>פנינו אליו בתחילה רק כדי לבדוק אם כדאי לשנות את המשכנתא שלנו. בפגישה השנייה גילינו לתדהמתנו שאנו יכולים לחסוך 260,000 ₪ במשכנתא.</p></blockquote>
            <figcaption><a href="<?php echo esc_url(home_url('/הסיפור-של-משפחת-סלומון-מהשרון/')); ?>">משפחת סלומון מהשרון</a></figcaption>
          </figure>
          <figure class="am-quote">
            <blockquote><p>התחלנו לחשוב על בית. משלנו. איך זה עובד? כמה ואיך לוקחים משכנתא, איך אפשר בכלל? מזל שעמיחי היה שם. ומלווה אותנו, כן, עדיין.</p></blockquote>
            <figcaption><a href="<?php echo esc_url(home_url('/הסיפור-של-משפחת-אשכול-מהדרום/')); ?>">משפחת אשכול מהדרום</a></figcaption>
          </figure>
          <figure class="am-quote">
            <blockquote><p>גילינו שאנחנו יכולים עם מעט הכסף שיש לנו לעשות הרבה יותר, וגם לקנות בית. היום אנחנו בהליכי קנייה של בית משלנו.</p></blockquote>
            <figcaption><a href="<?php echo esc_url(home_url('/הסיפור-של-משפחת-אקשטיין-מהצפון/')); ?>">משפחת אקשטיין מהצפון</a></figcaption>
          </figure>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php
  $related = [];
  foreach ($profile['related'] as $related_slug) {
      if ($related_slug === $slug) {
          continue;
      }
      $post = amichai_post_by_slug($related_slug);
      if ($post) {
          $related[] = $post;
      }
  }
  if ($related) :
      ?>
    <section class="am-hub-related" aria-labelledby="am-hub-related-title">
      <div class="am-wrap">
        <h2 id="am-hub-related-title" class="am-related-title">ממשיכים לקרוא</h2>
        <div class="am-topic-grid">
          <?php foreach ($related as $post) {
              amichai_topic_card($post);
          } ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php amichai_closing_cta('אפשר להתחיל בשיחה', 'שיחת היכרות, בלי התחייבות. אחריה תוכנית, וליווי צמוד לאורך הדרך.'); ?>
</main>
