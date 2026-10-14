<?php
/**
 * Template Name: אודות
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-about-page">
  <?php while (have_posts()) : the_post(); ?>
    <section class="am-about-hero">
      <div class="am-wrap am-about-hero-grid">
        <div>
          <nav class="am-crumbs" aria-label="מיקום בעמוד">
            <a href="<?php echo esc_url(home_url('/')); ?>">עמוד הבית</a>
            <span aria-hidden="true">/</span>
            <span>אודות</span>
          </nav>
          <h1>נעים להכיר, עמיחי מרקס</h1>
          <p class="am-hub-lead">יועץ ומאמן לכלכלת המשפחה ויועץ משכנתאות. 15 שנה אני מלווה משפחות, אחרי יותר מעשרים שנה במערכת הפיננסית בארץ ובחו״ל.</p>
          <ul class="am-about-facts">
            <li>15 שנה בליווי משפחות</li>
            <li>מעל 20 שנה בעולם הפיננסי</li>
            <li>חבר בהתאחדות יועצי המשכנתאות</li>
            <li>רישיון לייעוץ פנסיוני</li>
          </ul>
        </div>
        <aside class="am-hero-card" aria-label="עמיחי מרקס">
          <?php amichai_portrait('am-hero-photo'); ?>
          <div class="am-hero-card-body">
            <p class="am-hero-name">עמיחי מרקס</p>
            <p class="am-hero-role">יועץ ומאמן לכלכלת המשפחה<br>יועץ משכנתאות</p>
            <a class="am-hero-badge" href="#credentials">
              <span class="am-hero-badge-ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3 4.5 6.3V12c0 4.3 3 7.6 7.5 9 4.5-1.4 7.5-4.7 7.5-9V6.3L12 3z"/><path d="m8.6 12.2 2.3 2.3 4.6-4.8"/></svg></span>
              <span>הסמכות ותעודות</span>
            </a>
          </div>
        </aside>
      </div>
    </section>
    <div class="am-wrap am-about-body">
      <article class="am-prose">
        <?php the_content(); ?>
      </article>
      <aside class="am-about-certs" id="credentials" aria-labelledby="am-certs-title">
        <h2 id="am-certs-title">הסמכות ותעודות</h2>
        <?php amichai_credentials_list(); ?>
        <div class="am-cert-wall">
          <?php
          amichai_cert_figure('mortgage', 'am-cert-wide');
          amichai_cert_figure('family');
          amichai_cert_figure('coaching');
          ?>
        </div>
      </aside>
    </div>
  <?php endwhile; ?>
  <?php amichai_closing_cta('אפשר להתחיל בשיחה', 'שיחת היכרות, בלי התחייבות. אחריה תוכנית, וליווי צמוד לאורך הדרך.'); ?>
</main>
<?php
get_footer();
