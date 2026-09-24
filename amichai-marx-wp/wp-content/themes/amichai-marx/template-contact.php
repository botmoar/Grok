<?php
/**
 * Template Name: צור קשר
 */
defined('ABSPATH') || exit;
get_header();
$status = isset($_GET['lead']) ? sanitize_key(wp_unslash($_GET['lead'])) : '';
?>
<main id="main" class="am-page">
  <div class="am-wrap">
    <h1 class="am-page-title">צור קשר</h1>
    <p class="am-lead">שיחת ייעוץ מתחילה בטלפון או בטופס. בלי התחייבות.</p>
    <?php if ($status === 'ok') : ?>
      <p class="am-alert am-alert-ok">הפנייה התקבלה. עמיחי יחזור אליך. אם זה דחוף, אפשר גם להתקשר עכשיו.</p>
    <?php elseif ($status === 'err') : ?>
      <p class="am-alert am-alert-err">חסרים שם, טלפון, או אישור מדיניות הפרטיות. נסו שוב.</p>
    <?php endif; ?>
    <div class="am-contact-grid">
      <form class="am-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="amichai_lead">
        <?php wp_nonce_field('amichai_lead', 'amichai_lead_nonce'); ?>
        <label class="am-hp">אתר החברה
          <input type="text" name="company_website" tabindex="-1" autocomplete="off">
        </label>
        <label>שם מלא
          <input name="full_name" required autocomplete="name">
        </label>
        <label>טלפון
          <input name="phone" required autocomplete="tel" inputmode="tel">
        </label>
        <label>דוא״ל
          <input type="email" name="email" autocomplete="email">
        </label>
        <label>במה אפשר לעזור?
          <textarea name="message" rows="5"></textarea>
        </label>
        <label class="am-check">
          <input type="checkbox" name="privacy_ok" value="1" required>
          <span>קראתי את <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">מדיניות הפרטיות</a> ואני מסכים/ה שיחזרו אליי בעניין הפנייה.</span>
        </label>
        <button class="am-btn am-btn-primary" type="submit">לתיאום שיחת ייעוץ</button>
      </form>
      <aside class="am-contact-card">
        <h2>פרטי התקשרות</h2>
        <p><a href="tel:054-2372417">054-2372417</a></p>
        <p><a href="https://wa.me/972542372417" target="_blank" rel="noopener">וואטסאפ</a></p>
        <p><a href="mailto:marx@amichai-marx.co.il">marx@amichai-marx.co.il</a></p>
        <p>תל מנשה 11, חיננית</p>
        <p>ח.פ. 032965006</p>
        <p>פניות בנושא פרטיות: <a href="mailto:marx06@gmail.com">marx06@gmail.com</a></p>
        <p><a class="am-btn am-btn-ghost" href="tel:054-2372417">חייגו עכשיו</a></p>
      </aside>
    </div>
  </div>
</main>
<?php
get_footer();
