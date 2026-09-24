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

  <section class="am-flow-sec">
    <div class="am-wrap">
      <header class="am-sec-head">
        <h2>תהליך מובנה ומעמיק בשלושה שלבים</h2>
        <p>פגישת היכרות, פגישה שבה מוצגת התוכנית, ופגישת יישום. אחר כך ליווי, עד שהמשפחה מתנהלת בביטחון לבד.</p>
      </header>
      <ol class="am-flow">
        <li>
          <span class="am-flow-num">1</span>
          <span class="am-flow-ico" aria-hidden="true">
            <svg viewBox="0 0 48 48"><circle cx="24" cy="16" r="6"/><path d="M10 38c1.4-7.2 6-11 14-11s12.6 3.8 14 11"/></svg>
          </span>
          <h3><a href="<?php echo esc_url(home_url('/פגישה-מס-1-היכרות/')); ?>">פגישת היכרות</a></h3>
          <p>כשלוש שעות. הסיפור, המסמכים, הנכסים והיעדים.</p>
        </li>
        <li>
          <span class="am-flow-num">2</span>
          <span class="am-flow-ico" aria-hidden="true">
            <svg viewBox="0 0 48 48"><rect x="12" y="8" width="24" height="32" rx="3"/><path d="M18 18h12M18 25h12M18 32h7"/></svg>
          </span>
          <h3><a href="<?php echo esc_url(home_url('/פגישה-מס-2-הצגת-התוכנית/')); ?>">תוכנית עבודה</a></h3>
          <p>תמונת מצב, כמה חלופות, ודוח שהמשפחה לוקחת הביתה.</p>
        </li>
        <li>
          <span class="am-flow-num">3</span>
          <span class="am-flow-ico" aria-hidden="true">
            <svg viewBox="0 0 48 48"><path d="M24 40V22"/><path d="M24 28c-6 0-10-3.2-12-8 4 .2 8 2.2 12 8z"/><path d="M24 26c6 0 10-3.2 12-8-4 .2-8 2.2-12 8z"/><path d="M16 40h16"/></svg>
          </span>
          <h3><a href="<?php echo esc_url(home_url('/פגישה-מס-3-יישום-התוכנית/')); ?>">יישום וליווי</a></h3>
          <p>מהנייר להתנהלות היומיומית, ואז <a href="<?php echo esc_url(home_url('/ליווי/')); ?>">ליווי</a> עד שיש ביטחון להמשיך לבד.</p>
        </li>
      </ol>
    </div>
  </section>

  <section class="am-cover">
    <div class="am-wrap am-cover-grid">
      <div class="am-cover-copy">
        <h2>מעטפת פיננסית ופנסיונית תחת קורת גג</h2>
        <p>אני עמיחי מרקס. מעל 20 שנות ניסיון במערכת הפיננסית בארץ ובחו״ל, הסמכה לייעוץ כלכלת המשפחה, רישיון לייעוץ פנסיוני, וגם הכשרה כמאמן וכמגשר. את 2008 ראיתי מבפנים: שוק שנפל, ואנשים שאיבדו חסכונות בלי להבין למה. מאז הליווי של משפחות הוא העבודה עצמה, לא תוספת.</p>
        <p>ההתנהלות בבית, הביטוחים והפנסיה נבדקים באותו תהליך, לא אצל שלושה אנשים שונים.</p>
        <p class="am-more"><a href="<?php echo esc_url(home_url('/אודות/')); ?>">הסיפור המלא</a></p>
      </div>
      <ul class="am-cred-list">
        <li>
          <span class="am-cred-ico" aria-hidden="true">
            <svg viewBox="0 0 48 48"><path d="M24 6.5 10.5 12.4V24c0 8.4 5.3 14.6 13.5 17.5C32.2 38.6 37.5 32.4 37.5 24V12.4L24 6.5z"/><path d="m17.2 24.4 4.1 4.1 9.4-9.6"/></svg>
          </span>
          <span><strong>רישיון ייעוץ פנסיוני</strong><em>דמי ניהול, כיסויים, ומה שנשאר לגיל פרישה.</em></span>
        </li>
        <li>
          <span class="am-cred-ico" aria-hidden="true">
            <svg viewBox="0 0 48 48"><circle cx="16" cy="16" r="5"/><circle cx="32" cy="16" r="5"/><path d="M6 38c1-6 4.2-9 10-9s9 3 10 9"/><path d="M22 38c1-6 4.2-9 10-9s9 3 10 9"/></svg>
          </span>
          <span><strong>הסמכה כמאמן</strong><em>וגם הסמכה לייעוץ כלכלת המשפחה.</em></span>
        </li>
        <li>
          <span class="am-cred-ico" aria-hidden="true">
            <svg viewBox="0 0 48 48"><path d="M16 22c0-4 2.4-7 6-7h1"/><path d="M32 22c0-4-2.4-7-6-7"/><path d="M8 30c2.2-3 5.4-4.5 8.5-4.5 1.6 0 3 .3 4.2.9"/><path d="M40 30c-2.2-3-5.4-4.5-8.5-4.5-1.6 0-3 .3-4.2.9"/><path d="m18 33 4 4 8-9"/></svg>
          </span>
          <span><strong>הסמכה כמגשר</strong><em>כשההחלטות בבית צריכות גם שיחה, לא רק טבלה.</em></span>
        </li>
      </ul>
    </div>
  </section>

  <section class="am-soft">
    <div class="am-wrap am-soft-grid">
      <div>
        <h2>התאמה לכל שלב בחיים</h2>
        <p>מתאים למי שנמצא במינוס, וגם למי שמרוויח יפה ועדיין אין לו תמונה של הפנסיה, הביטוחים והיעדים. קריירה, דיור, פרישה, וחיסכון עתידי לילדים.</p>
      </div>
      <div class="am-soft-note">
        <span class="am-flow-ico" aria-hidden="true">
          <svg viewBox="0 0 48 48"><path d="M24 40V22"/><path d="M24 28c-6 0-10-3.2-12-8 4 .2 8 2.2 12 8z"/><path d="M24 26c6 0 10-3.2 12-8-4 .2-8 2.2-12 8z"/><path d="M16 40h16"/></svg>
        </span>
        <strong>תכנון נכון היום, ביטחון מחר.</strong>
      </div>
    </div>
  </section>

  <section class="am-letters">
    <div class="am-wrap">
      <h2 class="am-letters-title">מכתבים ממשפחות</h2>
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

  <section class="am-faq-sec">
    <div class="am-wrap am-faq">
      <h2>שאלות ותשובות</h2>
      <details>
        <summary>איך נראה התהליך, ובכמה מפגשים מדובר?</summary>
        <p>שלוש פגישות. הראשונה היכרות, בדרך כלל כשלוש שעות: הסיפור, המסמכים, הנכסים והיעדים. בשנייה מוצגת התוכנית, עם תמונת מצב ודוח שהמשפחה לוקחת הביתה. בשלישית עוברים מהנייר להתנהלות. אחר כך ליווי, עם שיחה שבועית, עד שיש ביטחון להמשיך לבד.</p>
      </details>
      <details>
        <summary>האם כדאי להגיע גם אם אין מינוס?</summary>
        <p>כן. הליווי מתאים גם למי שמרוויח יפה ועדיין אין לו תמונה של הפנסיה, הביטוחים והיעדים.</p>
      </details>
      <details>
        <summary>האם נבדקים גם הביטוחים והפנסיה?</summary>
        <p>כן. באותו תהליך נבדקים הביטוחים, כפל כיסויים ודמי הניהול בפנסיה, לצד ההתנהלות השוטפת בבית.</p>
      </details>
      <details>
        <summary>מה הניסיון וההסמכות של עמיחי מרקס?</summary>
        <p>מעל 20 שנות ניסיון במערכת הפיננסית בארץ ובחו״ל, הסמכה לייעוץ כלכלת המשפחה, רישיון לייעוץ פנסיוני, והכשרה כמאמן וכמגשר.</p>
      </details>
    </div>
  </section>

  <section class="am-band-last">
    <div class="am-wrap">
      <div class="am-cta-band am-cta-close">
        <div>
          <h2>מוכנים לצאת לדרך?</h2>
          <p>שיחת היכרות, בלי התחייבות.</p>
          <p class="am-cta-meta"><span class="am-email" dir="ltr">marx@amichai-marx.co.il</span><span>תל מנשה 11, חיננית</span></p>
        </div>
        <div class="am-actions">
          <a class="am-btn am-btn-primary" href="tel:054-2372417">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            054-2372417
          </a>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
