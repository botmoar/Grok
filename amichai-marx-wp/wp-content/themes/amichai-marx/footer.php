<?php defined('ABSPATH') || exit; ?>
<footer class="am-footer">
  <div class="am-wrap am-footer-grid">
    <div>
      <a class="am-logo am-logo-light" href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo esc_url(amichai_asset('assets/images/logo.svg')); ?>" width="42" height="42" alt="">
        <span>עמיחי מרקס</span>
      </a>
      <p>ייעוץ לכלכלת המשפחה וביטחון פיננסי. ליווי אישי למשפחות שרוצות סדר, שקט ותוכנית.</p>
    </div>
    <div>
      <h2>ניווט</h2>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/אודות/')); ?>">אודות</a></li>
        <li><a href="<?php echo esc_url(home_url('/ייעוץ-לכלכלת-המשפחה/')); ?>">ייעוץ לכלכלת המשפחה</a></li>
        <li><a href="<?php echo esc_url(home_url('/סיפורי-משפחות/')); ?>">סיפורי משפחות</a></li>
        <li><a href="<?php echo esc_url(home_url('/כלי-עזר/')); ?>">כלי עזר</a></li>
        <li><a href="<?php echo esc_url(home_url('/מן-התקשורת/')); ?>">מן התקשורת</a></li>
        <li><a href="<?php echo esc_url(home_url('/מאמרים/')); ?>">מאמרים</a></li>
        <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">מדיניות פרטיות</a></li>
      </ul>
    </div>
    <div>
      <h2>יצירת קשר</h2>
      <ul>
        <li><a href="tel:054-2372417">054-2372417</a></li>
        <li><a href="mailto:marx@amichai-marx.co.il">marx@amichai-marx.co.il</a></li>
        <li>תל מנשה 11, חיננית</li>
        <li>ח.פ. 032965006</li>
      </ul>
      <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>
    </div>
  </div>
  <div class="am-wrap am-footer-base">
    <p>© <?php echo esc_html(gmdate('Y')); ?> עמיחי מרקס. חבר באיגוד היועצים והמאמנים לכלכלת המשפחה בישראל.</p>
    <img src="<?php echo esc_url(amichai_asset('assets/images/association.png')); ?>" width="120" height="48" alt="לוגו איגוד היועצים והמאמנים לכלכלת המשפחה בישראל">
  </div>
</footer>
<div class="am-mobile-cta">
  <a href="tel:054-2372417">חייגו עכשיו</a>
  <a href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>
</div>
<?php wp_footer(); ?>
</body>
</html>
