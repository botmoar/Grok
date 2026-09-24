<?php
/**
 * Template Name: אודות
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap am-split">
    <aside class="am-about-aside">
      <img class="am-side-photo" src="<?php echo esc_url(amichai_asset('assets/images/hero-portrait.png')); ?>" width="620" height="705" alt="עמיחי מרקס">
      <ul class="am-facts">
        <li>מעל 20 שנות ניסיון</li>
        <li>הסמכה לייעוץ כלכלת המשפחה</li>
        <li>רישיון ייעוץ פנסיוני</li>
        <li>מאמן מוסמך ומגשר מוסמך</li>
        <li>חבר באיגוד היועצים והמאמנים לכלכלת המשפחה בישראל</li>
      </ul>
    </aside>
    <article class="am-prose">
      <?php while (have_posts()) : the_post(); ?>
        <h1 class="am-page-title"><?php the_title(); ?></h1>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </article>
  </div>
</main>
<?php
get_footer();
