<?php
/**
 * Template Name: אודות
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <div class="am-wrap am-split">
    <aside>
      <img class="am-side-photo" src="<?php echo esc_url(amichai_asset('assets/images/portrait.webp')); ?>" alt="עמיחי מרקס">
      <ul class="am-chips">
        <li>מעל 20 שנה במערכת הפיננסית</li>
        <li>הסמכה לייעוץ כלכלת המשפחה</li>
        <li>רישיון ייעוץ פנסיוני</li>
        <li>מאמן מוסמך</li>
        <li>מגשר מוסמך</li>
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
