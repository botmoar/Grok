<?php
/**
 * Template Name: תודה
 */
defined('ABSPATH') || exit;
get_header();
$articles = [
    ['slug' => 'יועץ-לכלכלת-המשפחה', 'title' => 'ייעוץ לכלכלת המשפחה'],
    ['slug' => 'דיור-ומשכנתאות', 'title' => 'ייעוץ משכנתאות ודיור'],
    ['slug' => 'ניהול-תקציב-משפחתי', 'title' => 'ניהול תקציב משפחתי'],
];
?>
<main id="main" class="am-page">
  <div class="am-wrap am-thanks">
    <h1>תודה, הפנייה התקבלה</h1>
    <p class="am-lede">עמיחי קיבל את הפרטים שלך ויחזור אליך בהקדם, בדרך כלל תוך יום עסקים. אם הנושא דחוף, אפשר גם לכתוב עכשיו בוואטסאפ.</p>
    <div class="am-actions">
      <a class="am-btn am-btn-primary" href="<?php echo esc_url(amichai_whatsapp_url()); ?>" target="_blank" rel="noopener">שליחה בוואטסאפ</a>
      <a class="am-btn am-btn-ghost" href="<?php echo esc_url(home_url('/')); ?>">חזרה לדף הבית</a>
    </div>
    <nav class="am-thanks-links" aria-label="מאמרים">
      <h2>בינתיים, כמה דברים שאפשר לקרוא</h2>
      <ul>
        <?php foreach ($articles as $item) : ?>
          <li><a href="<?php echo esc_url(home_url('/' . $item['slug'] . '/')); ?>"><?php echo esc_html($item['title']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </div>
</main>
<?php get_footer();
