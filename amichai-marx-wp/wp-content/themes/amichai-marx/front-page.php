<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main">
  <section class="am-hero">
    <div class="am-wrap am-hero-grid">
      <div class="am-hero-copy">
        <h1>ייעוץ לכלכלת המשפחה<br><span>וביטחון פיננסי</span></h1>
        <p class="am-lead">מעל 20 שנות ניסיון בליווי משפחות לצמיחה ותכנון נכון</p>
        <div class="am-actions">
          <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">
            לתיאום שיחת ייעוץ
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="M14 6 8 12l6 6"/></svg>
          </a>
          <a class="am-btn am-btn-ghost" href="tel:054-2372417">
            <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            חייגו עכשיו
          </a>
        </div>
        <ul class="am-trust">
          <li>
            <svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 6.5 10.5 12.4V24c0 8.4 5.3 14.6 13.5 17.5C32.2 38.6 37.5 32.4 37.5 24V12.4L24 6.5z"/><path class="am-accent" d="m17.2 24.4 4.1 4.1 9.4-9.6"/></svg>
            <span>מעל 20 שנות<br>ניסיון פיננסי</span>
          </li>
          <li>
            <svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="12.5" cy="14" r="3.1"/><path d="M6.2 35.5c.7-5.6 3.2-8.4 6.3-8.4s5.6 2.8 6.3 8.4"/><circle cx="35.5" cy="14" r="3.1"/><path d="M29.2 35.5c.7-5.6 3.2-8.4 6.3-8.4s5.6 2.8 6.3 8.4"/><circle cx="24" cy="18.2" r="2.5"/><path d="M19.2 35.5c.55-4.3 2.3-6.5 4.8-6.5s4.25 2.2 4.8 6.5"/></svg>
            <span>ליווי אישי מותאם<br>למשפחה</span>
          </li>
          <li>
            <svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="21.5" cy="26.5" r="11.2"/><circle cx="21.5" cy="26.5" r="6"/><circle cx="21.5" cy="26.5" r="1.5" fill="currentColor" stroke="none"/><path class="am-accent" d="M29.2 18.8 39.5 8.5"/><path class="am-accent" d="M32.2 8.5H39.5V15.8"/></svg>
            <span>תכנון תקציב<br>ויעדים</span>
          </li>
        </ul>
      </div>
      <div class="am-portrait-wrap">
        <img class="am-portrait" src="<?php echo esc_url(amichai_asset('assets/images/hero-portrait.png')); ?>" width="620" height="705" alt="עמיחי מרקס, יועץ לכלכלת המשפחה">
      </div>
    </div>
  </section>

  <section class="am-band">
    <div class="am-wrap am-about-grid">
      <figure class="am-about-photo">
        <img src="<?php echo esc_url(amichai_asset('assets/images/hero-portrait.png')); ?>" width="620" height="705" alt="עמיחי מרקס">
        <figcaption>עמיחי מרקס</figcaption>
      </figure>
      <div class="am-about-copy">
        <h2>יושב עם המשפחה, לא מרצה לה.</h2>
        <p>אני עמיחי מרקס. מעל 20 שנות ניסיון במערכת הפיננסית בארץ ובחו״ל, הסמכה לייעוץ כלכלת המשפחה, רישיון לייעוץ פנסיוני, וגם הכשרה כמאמן וכמגשר. את 2008 ראיתי מבפנים: שוק שנפל, ואנשים שאיבדו חסכונות בלי להבין למה. מאז הליווי של משפחות הוא העבודה עצמה, לא תוספת.</p>
        <p>מתאים למי שנמצא במינוס, וגם למי שמרוויח יפה ועדיין אין לו תמונה של הפנסיה, הביטוחים והיעדים.</p>
        <p class="am-more"><a href="<?php echo esc_url(home_url('/אודות/')); ?>">הסיפור המלא</a></p>
      </div>
    </div>
  </section>

  <section class="am-band am-band-plain">
    <div class="am-wrap">
      <div class="am-work">
        <div class="am-work-lead">
          <h2>על מה עובדים</h2>
          <p>ארבעה מעגלים, בבית אחד: הניהול השוטף, היציאה מלחץ, הדיור, ומה שנשאר לפנסיה וליעדים. הפירוט נמצא בעמוד <a href="<?php echo esc_url(home_url('/יועץ-לכלכלת-המשפחה/')); ?>">יועץ לכלכלת המשפחה</a>.</p>
          <p class="am-more"><a href="<?php echo esc_url(home_url('/מחשבון-תקציב-משפחתי/')); ?>">מחשבון תקציב</a> · <a href="<?php echo esc_url(home_url('/מחשבון-חיסכון-משפחתי-ליעדים/')); ?>">מחשבון חיסכון ליעדים</a></p>
        </div>
        <ul class="am-work-list">
          <li><a href="<?php echo esc_url(home_url('/ניהול-תקציב-משפחתי/')); ?>"><strong>ניהול תקציב</strong><span>הכנסות מול הוצאות, בלי לנחש לאן נעלם החודש.</span></a></li>
          <li><a href="<?php echo esc_url(home_url('/איך-לצאת-מהמינוס/')); ?>"><strong>יציאה מהמינוס</strong><span>מינוס הוא הלוואה יקרה. יש סדר פעולות לצאת ממנו.</span></a></li>
          <li><a href="<?php echo esc_url(home_url('/יציאה-מחובות/')); ?>"><strong>יציאה מחובות</strong><span>כשיש כמה הלוואות, לא רק שורה אחת באדום.</span></a></li>
          <li><a href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/')); ?>"><strong>דיור ומשכנתאות</strong><span>שכירות או קנייה, תמהיל, ומחיר אמיתי של הקפאה.</span></a></li>
          <li><a href="<?php echo esc_url(home_url('/פנסיה/')); ?>"><strong>פנסיה וביטוחים</strong><span>דמי ניהול, כפל כיסויים, ומה באמת יחכה בגיל פרישה.</span></a></li>
          <li><a href="<?php echo esc_url(home_url('/הרצאות-וסדנאות/')); ?>"><strong>הרצאות וסדנאות</strong><span>מפגשים לארגונים וקהילות, וגם קורס התנהלות.</span></a></li>
        </ul>
      </div>
    </div>
  </section>

  <section class="am-band">
    <div class="am-wrap am-process">
      <div>
        <h2>איך נראית העבודה</h2>
        <p>קודם פגישת היכרות, אחר כך פגישה שבה מוצגת התוכנית, ואז פגישת יישום. שלוש פגישות. אחר כך ליווי, עד שהמשפחה מתנהלת בביטחון לבד.</p>
      </div>
      <ol>
        <li>
          <a href="<?php echo esc_url(home_url('/פגישה-מס-1-היכרות/')); ?>">
            <strong>היכרות</strong>
            <em>כשלוש שעות. הסיפור, המסמכים, הנכסים והיעדים.</em>
          </a>
        </li>
        <li>
          <a href="<?php echo esc_url(home_url('/פגישה-מס-2-הצגת-התוכנית/')); ?>">
            <strong>הצגת התוכנית</strong>
            <em>תמונת מצב, כמה חלופות, ודוח שהמשפחה לוקחת הביתה.</em>
          </a>
        </li>
        <li>
          <a href="<?php echo esc_url(home_url('/פגישה-מס-3-יישום-התוכנית/')); ?>">
            <strong>יישום</strong>
            <em>מהנייר להתנהלות היומיומית, עם כלים שעובדים בבית הזה.</em>
          </a>
        </li>
        <li>
          <a href="<?php echo esc_url(home_url('/ליווי/')); ?>">
            <strong>ליווי</strong>
            <em>שאלות בדרך ושיחה שבועית, עד שיש ביטחון להמשיך לבד.</em>
          </a>
        </li>
      </ol>
    </div>
  </section>

  <section class="am-letters">
    <div class="am-wrap">
      <blockquote class="am-letter-feature">
        <p>לאחר התהליך שעברנו אצלך הבנו שלמעשה שנים רבות לא ניהלנו את חיינו, ולכן חיינו בבינוניות ומהיד לפה, לאחר הייעוץ הרגשנו שעולם השפע נפתח לנו, בעזרת הליווי הרגיש והצמוד שלך הצלחנו לצאת לדרך חדשה, דרך אותה בנית עבורנו כעבודת אומן, מותאמת לצרכינו ולערכינו, כיום אנו כבר רואים תוצאות ומצליחים לשמר אותן לאורך זמן.</p>
        <footer><a href="<?php echo esc_url(home_url('/המלצה/')); ?>">ערן ושרון</a></footer>
      </blockquote>
      <div class="am-letter-rest">
        <blockquote>
          <p>למדנו לנהל תקציב משפחתי נכון ומאוזן, למדנו מהי תודעה עשירה וכך הרכבנו תקציב נכון וטוב שהביא אותנו לצמיחה ממשית. נתת לנו ביטחון לעתיד טוב יותר, אנו מצליחים לנהל את כספנו בחוכמה ולא שהבנק ינהל אותנו.</p>
          <footer><a href="<?php echo esc_url(home_url('/מכתב-תודה-לעמיחי-טלי-וחנן/')); ?>">טלי וחנן, משפחת בר-און</a></footer>
        </blockquote>
        <blockquote>
          <p>הקהל שיבח והרעיף מחמאות על הפרקטיות של ההרצאה כמו גם על אופן העברתה על ידי עמיחי. ממליצה בכל פה על ההרצאה – היא רלוונטית לקהל מגוון.</p>
          <footer><a href="<?php echo esc_url(home_url('/המלצה-מפנינה-שלומיוק-מנהלת-הספרייה/')); ?>">פנינה שלומיוק, הספרייה הציבורית אזור</a></footer>
          <p class="am-letter-more"><a href="<?php echo esc_url(home_url('/סיפורי-משפחות/')); ?>">סיפורי משפחות</a></p>
        </blockquote>
      </div>
    </div>
  </section>

  <section class="am-band am-band-last">
    <div class="am-wrap">
      <div class="am-cta-band">
        <div>
          <h2>שיחת היכרות, בלי התחייבות</h2>
          <p class="am-cta-meta"><span>054-2372417</span><span class="am-email" dir="ltr">marx@amichai-marx.co.il</span><span>תל מנשה 11, חיננית</span></p>
        </div>
        <div class="am-actions">
          <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>
          <a class="am-btn am-btn-ghost am-btn-on-dark" href="tel:054-2372417">חייגו עכשיו</a>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
