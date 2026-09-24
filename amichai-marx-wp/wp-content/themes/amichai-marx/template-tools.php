<?php
/**
 * Template Name: כלי עזר
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap">
    <h1 class="am-page-title">כלי עזר לכלכלת המשפחה</h1>
    <p class="am-lead">המחשבונים להמחשה בלבד. הם לא מחליפים ייעוץ שמתחשב במסמכים של הבית.</p>
    <div class="am-tool-grid">
      <article class="am-card">
        <h2>מחשבון תקציב משפחתי</h2>
        <p>הזינו הכנסות, הוצאות קבועות והוצאות משתנות וקבלו את היתרה החודשית ואת יחס ההוצאות להכנסות.</p>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/מחשבון-תקציב-משפחתי/')); ?>">מעבר למחשבון</a>
      </article>
      <article class="am-card">
        <h2>מחשבון חיסכון משפחתי ליעדים</h2>
        <p>רוצים לדעת כמה לחסוך כדי לעמוד ביעדים שהצבתם? המחשבון מחשב הפקדה חודשית קבועה ודינמית.</p>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/מחשבון-חיסכון-משפחתי-ליעדים/')); ?>">מעבר למחשבון</a>
      </article>
    </div>
    <p style="margin-top:22px">מקורות רשמיים לבדיקת ביטוחים, כספים אבודים וזכויות: <a href="<?php echo esc_url(home_url('/קישורים/')); ?>">קישורים ומקורות מידע</a>.</p>
  </div>
</main>
<?php
get_footer();
