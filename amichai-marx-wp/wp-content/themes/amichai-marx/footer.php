<?php defined('ABSPATH') || exit; ?>
<footer class="am-footer">
  <div class="am-wrap am-footer-grid">
    <div class="am-footer-brand">
      <a class="am-logo am-logo-footer" href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo esc_url(amichai_asset('assets/images/logo.png')); ?>" width="492" height="120" loading="lazy" alt="עמיחי מרקס, יועץ ומאמן לכלכלת המשפחה">
      </a>
      <p>ליווי אישי למשפחות שרוצות סדר בחשבון, ותוכנית שאפשר לחיות איתה.</p>
      <img class="am-footer-assoc" src="<?php echo esc_url(amichai_asset('assets/images/association.png')); ?>" width="120" height="48" loading="lazy" alt="חבר באיגוד היועצים והמאמנים לכלכלת המשפחה בישראל">
    </div>
    <?php foreach (amichai_footer_columns() as $column) : ?>
      <nav class="am-footer-col" aria-label="<?php echo esc_attr($column['title']); ?>">
        <h2><?php echo esc_html($column['title']); ?></h2>
        <?php amichai_render_flat_links($column['items']); ?>
      </nav>
    <?php endforeach; ?>
    <div class="am-footer-contact">
      <h2>יצירת קשר</h2>
      <ul>
        <li><a href="tel:054-2372417">054-2372417</a></li>
        <li><a href="<?php echo esc_url(amichai_whatsapp_url()); ?>" target="_blank" rel="noopener">וואטסאפ</a></li>
        <li><a href="mailto:marx@amichai-marx.co.il" dir="ltr">marx@amichai-marx.co.il</a></li>
        <li>תל מנשה 11, חיננית</li>
      </ul>
    </div>
  </div>
  <div class="am-footer-base">
    <div class="am-wrap">
      <p>© <?php echo esc_html(gmdate('Y')); ?> עמיחי מרקס · ח.פ. 032965006</p>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">צור קשר</a></li>
        <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">מדיניות פרטיות</a></li>
        <li><a href="<?php echo esc_url(home_url('/הצהרת-נגישות/')); ?>">הצהרת נגישות</a></li>
      </ul>
    </div>
  </div>
</footer>
<a class="am-whatsapp" href="<?php echo esc_url(amichai_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer" aria-label="שליחת וואטסאפ">
  <svg viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><path fill="currentColor" d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.4a10 10 0 0 0 4.65 1.18h.01c5.46 0 9.89-4.4 9.89-9.83C21.94 6.4 17.5 2 12.04 2zm5.76 14.05c-.24.68-1.4 1.3-1.94 1.38-.5.07-1.12.1-1.81-.11-.41-.13-.95-.31-1.63-.6-2.87-1.24-4.74-4.13-4.88-4.32-.14-.19-1.16-1.54-1.16-2.94s.73-2.08 1-2.37c.24-.28.64-.41 1.02-.41.12 0 .23 0 .33.01.3.01.44.03.64.49.24.58.82 2 .89 2.15.07.14.12.31.02.5-.09.19-.14.31-.28.48-.14.16-.29.37-.42.49-.14.14-.28.29-.12.55.16.26.7 1.15 1.5 1.86 1.03.92 1.9 1.2 2.17 1.34.26.13.42.11.57-.07.16-.19.66-.77.84-1.03.18-.26.35-.22.58-.13.24.09 1.49.7 1.74.83.26.13.43.19.49.3.07.11.07.64-.17 1.32z"/></svg>
</a>
<div class="am-mobile-cta">
  <a href="tel:054-2372417">חייגו עכשיו</a>
  <a href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>
</div>
<?php wp_footer(); ?>
</body>
</html>
