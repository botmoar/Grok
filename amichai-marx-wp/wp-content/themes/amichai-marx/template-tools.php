<?php
/**
 * Template Name: כלי עזר
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap am-tools">
    <h1 class="am-page-title">כלי עזר לכלכלת המשפחה</h1>
    <p class="am-lead">המחשבונים להמחשה בלבד. הם לא מחליפים ייעוץ שמתחשב במסמכים של הבית.</p>
    <div class="am-tool-grid">
      <article class="am-tool-card">
        <span class="am-tool-ico" aria-hidden="true">
          <svg viewBox="0 0 48 48"><rect x="10" y="8" width="28" height="32" rx="4"/><path d="M16 16h16M16 23h6M26 23h6M16 30h6M26 30h6"/></svg>
        </span>
        <p class="am-tool-kicker">מחשבון</p>
        <h2>מחשבון תקציב משפחתי</h2>
        <p>הזינו הכנסות, הוצאות קבועות והוצאות משתנות, וקבלו את היתרה החודשית ואת יחס ההוצאות להכנסות.</p>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/מחשבון-תקציב-משפחתי/')); ?>">מעבר למחשבון</a>
      </article>
      <article class="am-tool-card">
        <span class="am-tool-ico" aria-hidden="true">
          <svg viewBox="0 0 48 48"><path d="M10 34V14"/><path d="M10 34h28"/><path d="M16 28l6-7 5 4 9-11"/><path class="am-accent" d="M30 14h8v8"/></svg>
        </span>
        <p class="am-tool-kicker">מחשבון</p>
        <h2>מחשבון חיסכון משפחתי ליעדים</h2>
        <p>כמה לחסוך כדי לעמוד ביעדים שהצבתם? המחשבון מחשב הפקדה חודשית קבועה ודינמית.</p>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/מחשבון-חיסכון-משפחתי-ליעדים/')); ?>">מעבר למחשבון</a>
      </article>
    </div>
    <section class="am-tools-sources" aria-labelledby="am-sources-title">
      <h2 id="am-sources-title">מקורות רשמיים</h2>
      <p>לבדיקת ביטוחים, כספים אבודים וזכויות, התחילו ברשימת הגופים הרשמיים. <a href="<?php echo esc_url(home_url('/קישורים/')); ?>">קישורים ומקורות מידע</a></p>
    </section>
    <aside class="am-intro-cta am-tools-cta" aria-label="שיחת היכרות">
      <p>רוצים לעבור על המספרים יחד? שיחת היכרות, בלי התחייבות.</p>
      <div class="am-intro-cta-actions">
        <?php amichai_whatsapp_button(); ?>
        <a class="am-intro-link" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת היכרות</a>
      </div>
    </aside>
  </div>
</main>
<?php
get_footer();
