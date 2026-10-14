<?php
/**
 * Template Name: מן התקשורת
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="am-page">
  <?php amichai_page_hero('מן התקשורת', 'קטעים מתוכניות טלוויזיה ורדיו שבהן עמיחי מרקס דיבר על כלכלת המשפחה.', 'עמיחי מרקס בתקשורת'); ?>
  <div class="am-wrap am-prose">
    <h2>התוכנית לבחור נכון, עם מיכל צפיר</h2>
    <div class="am-videos">
      <figure>
        <div class="am-video">
          <iframe src="https://www.youtube-nocookie.com/embed/ujQGqrQkhz0" title="עמיחי מרקס - כלכלת המשפחה דיאטה ומה שביניהם" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <figcaption>עמיחי מרקס – כלכלת המשפחה, דיאטה ומה שביניהן</figcaption>
      </figure>
      <figure>
        <div class="am-video">
          <iframe src="https://www.youtube-nocookie.com/embed/UqsA1gk_GHs" title="עמיחי מרקס - כלכלת המשפחה לקראת החגים" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <figcaption>עמיחי מרקס – כלכלת המשפחה לקראת החגים</figcaption>
      </figure>
    </div>
    <h2>ראיון ברדיו קול ברמה, עם שיפי חריטן</h2>
    <div class="am-audio">
      <img src="<?php echo esc_url(amichai_asset('assets/images/kol-barama.png')); ?>" alt="קול ברמה">
      <div>
        <p>הקלטת הראיון מ־18.10.2022, כפי שפורסמה באתר.</p>
        <audio controls preload="none" src="<?php echo esc_url(amichai_asset('assets/media/kol-barama-2022-10-18.mp3')); ?>">
          <a href="<?php echo esc_url(amichai_asset('assets/media/kol-barama-2022-10-18.mp3')); ?>">הורדת הראיון</a>
        </audio>
      </div>
    </div>
    <p>אחרי חגים והוצאות גדולות, עמיחי דיבר באותו ראיון על חזרה לשגרה והתמודדות עם המינוס. הצעדים המעשיים מופיעים במדריך <a href="<?php echo esc_url(home_url('/איך-לצאת-מהמינוס/')); ?>">איך לצאת מהמינוס</a>.</p>
  </div>
</main>
<?php
get_footer();
