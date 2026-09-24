<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap am-prose">
    <p class="am-quiet">404</p>
    <h1 class="am-page-title">העמוד הזה לא נמצא</h1>
    <p>ייתכן שהקישור ישן, או שהעמוד אוחד לעמוד חזק יותר. אפשר לחפש, לחזור הביתה, או פשוט להתקשר.</p>
    <?php get_search_form(); ?>
    <p>
      <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/')); ?>">לעמוד הבית</a>
      <a class="am-btn am-btn-ghost" href="tel:054-2372417">חייגו עכשיו</a>
    </p>
    <ul>
      <li><a href="<?php echo esc_url(home_url('/יועץ-לכלכלת-המשפחה/')); ?>">יועץ לכלכלת המשפחה</a></li>
      <li><a href="<?php echo esc_url(home_url('/ניהול-תקציב-משפחתי/')); ?>">ניהול תקציב משפחתי</a></li>
      <li><a href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">צור קשר</a></li>
    </ul>
  </div>
</main>
<?php
get_footer();
