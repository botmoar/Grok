<?php
defined('ABSPATH') || exit;
get_header();
$arrow = '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="M14 6 8 12l6 6"/></svg>';
?>
<main id="main" class="am-home">
  <section class="am-hero">
    <div class="am-wrap am-hero-grid">
      <div class="am-hero-copy">
        <p class="am-kicker">עמיחי מרקס</p>
        <h1>ייעוץ לכלכלת המשפחה <span>ומשכנתאות, בליווי צמוד</span></h1>
        <p class="am-lead">תקציב ומינוס, משכנתא, חסכונות והשקעות, בתוכנית אחת שבונים יחד. ואחרי התוכנית אני ממשיך ללוות אתכם, כל עוד צריך.</p>
        <div class="am-actions">
          <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת היכרות <?php echo $arrow; ?></a>
          <a class="am-btn am-btn-ghost" href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/')); ?>">ייעוץ משכנתאות</a>
        </div>
      </div>
      <aside class="am-hero-card" aria-label="עמיחי מרקס">
        <?php amichai_portrait('am-hero-photo'); ?>
        <div class="am-hero-card-body">
          <p class="am-hero-name">עמיחי מרקס</p>
          <p class="am-hero-role">יועץ לכלכלת המשפחה ויועץ משכנתאות</p>
        </div>
      </aside>
      <ul class="am-trust" aria-label="בקצרה">
        <?php
        $trust = [
            ['15 שנה', 'בליווי משפחות', 'M16 19v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 17.5V19M10 10.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM20 19v-1.4a3.2 3.2 0 0 0-2.4-3.1M15.5 4.6a3 3 0 0 1 0 5.8'],
            ['מעל 20 שנה', 'בעולם הפיננסי', 'M4 19.5h16M7 16v-5M12 16V6.5M17 16V9'],
            ['יועץ משכנתאות', 'חבר בהתאחדות', 'M3 11.5 12 4l9 7.5M5.5 9.8V20h13V9.8M10 20v-5.5h4V20'],
            ['ליווי צמוד', 'גם אחרי התוכנית', 'M6 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM18 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM6 16V10a4 4 0 0 1 4-4h6M18 8v6a4 4 0 0 1-4 4H8'],
        ];
        foreach ($trust as [$title, $label, $icon]) :
            ?>
          <li>
            <span class="am-trust-ico"><?php echo amichai_mortgage_icon($icon); ?></span>
            <span class="am-trust-text"><strong><?php echo esc_html($title); ?></strong><span><?php echo esc_html($label); ?></span></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="am-services" aria-labelledby="am-services-title">
    <div class="am-wrap">
      <header class="am-sec-head">
        <p class="am-kicker">שירותים</p>
        <h2 id="am-services-title">במה אני מלווה משפחות</h2>
        <p>ההתנהלות השוטפת, המשכנתא, החסכונות, הביטוחים והפנסיה נבדקים באותו תהליך ואצל אותו אדם. כך ההחלטות מתחברות זו לזו, ולא סותרות.</p>
      </header>
      <div class="am-service-grid">
        <a class="am-service am-service-key" href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/')); ?>">
          <span class="am-service-ico" aria-hidden="true"><svg viewBox="0 0 48 48" width="26" height="26" stroke-width="1.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M8 22 24 9l16 13"/><path d="M12 19v20h24V19"/><path d="M20 39V28h8v11"/></svg></span>
          <span class="am-service-head">
            <strong>משכנתאות ודיור</strong>
          </span>
          <span class="am-service-text">לקנות או לשכור, בניית תמהיל ומחזור משכנתא. החלטה שעולה או חוסכת מאות אלפי שקלים.</span>
          <em>לעמוד המשכנתאות</em>
        </a>
        <a class="am-service am-service-grow" href="<?php echo esc_url(home_url('/חסכונות/')); ?>">
          <span class="am-service-ico" aria-hidden="true"><svg viewBox="0 0 48 48" width="26" height="26" stroke-width="1.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M8 38h32"/><path d="M12 32l8-9 6 5 11-13"/><path d="M30 15h7v7"/></svg></span>
          <span class="am-service-head">
            <strong>צמיחה, חסכונות והשקעות</strong>
          </span>
          <span class="am-service-text">חיסכון עם יעד, בדיקת תשואה, סיכון ודמי ניהול, וחיסכון לילדים.</span>
          <em>לעמוד הצמיחה</em>
        </a>
        <a class="am-service" href="<?php echo esc_url(home_url('/חיים-במינוס/')); ?>">
          <span class="am-service-ico" aria-hidden="true"><svg viewBox="0 0 48 48" width="26" height="26" stroke-width="1.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="9" y="12" width="30" height="24" rx="4"/><path d="M9 20h30"/><path d="M16 29h7"/></svg></span>
          <span class="am-service-head">
            <strong>תקציב ויציאה מהמינוס</strong>
          </span>
          <span class="am-service-text">תמונת מצב אמיתית, תוכנית שאפשר לחיות איתה, ויציאה מהמינוס בסדר פעולות.</span>
          <em>לקריאה</em>
        </a>
        <a class="am-service" href="<?php echo esc_url(home_url('/פנסיה/')); ?>">
          <span class="am-service-ico" aria-hidden="true"><svg viewBox="0 0 48 48" width="26" height="26" stroke-width="1.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="24" cy="24" r="14"/><path d="M24 16v8l6 4"/></svg></span>
          <span class="am-service-head">
            <strong>פנסיה</strong>
          </span>
          <span class="am-service-text">כמה תקבלו בפרישה, איפה הכסף מושקע, וכמה דמי ניהול גובים מכם.</span>
          <em>לקריאה</em>
        </a>
        <a class="am-service" href="<?php echo esc_url(home_url('/ביטוחים/')); ?>">
          <span class="am-service-ico" aria-hidden="true"><svg viewBox="0 0 48 48" width="26" height="26" stroke-width="1.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M24 7 11 12.5V23c0 8 5 13.8 13 16.5C32 36.8 37 31 37 23V12.5L24 7z"/><path d="m18 23.5 4 4 8.5-8.5"/></svg></span>
          <span class="am-service-head">
            <strong>ביטוחים</strong>
          </span>
          <span class="am-service-text">כפל כיסויים, חוסרים, ומה באמת צריך כדי שהבית יהיה מוגן.</span>
          <em>לקריאה</em>
        </a>
        <a class="am-service" href="<?php echo esc_url(home_url('/דילמות-כלכליות/')); ?>">
          <span class="am-service-ico" aria-hidden="true"><svg viewBox="0 0 48 48" width="26" height="26" stroke-width="1.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M24 8v32"/><path d="M12 14h24"/><path d="M12 14 7 26a5 5 0 0 0 10 0l-5-12z"/><path d="M36 14l-5 12a5 5 0 0 0 10 0l-5-12z"/></svg></span>
          <span class="am-service-head">
            <strong>החלטות גדולות</strong>
          </span>
          <span class="am-service-text">חתונה, מעבר דירה, שינוי עבודה, גירושין או פרישה. לפני ההחלטה, לא אחריה.</span>
          <em>לקריאה</em>
        </a>
      </div>
    </div>
  </section>

  <section class="am-mortgage" aria-labelledby="am-mortgage-title">
    <div class="am-wrap am-mortgage-grid">
      <div class="am-mortgage-copy">
        <p class="am-kicker am-kicker-light">משכנתאות</p>
        <h2 id="am-mortgage-title">ייעוץ משכנתאות כחלק מהתוכנית הכלכלית</h2>
        <p>רכישת בית היא כנראה העסקה הגדולה בחיים. הבנקים מוסיפים פרמטרים וחישובים שמקשים על השוואה בין הצעות, וההבדל בין משכנתא טובה לרעה מורגש בכיס כל חודש, לאורך רוב שנות העבודה.</p>
        <p>לכן ייעוץ משכנתאות מתחיל אצלי מהמשפחה, לא מהבנק: ההכנסות, ההוצאות, ההון העצמי והיעדים. רק מתוך התמונה הזו בונים תמהיל שמשלמים עליו לבנק פחות.</p>
        <ul class="am-checks am-checks-light">
          <li>האם לקנות עכשיו, או להמשיך לשכור</li>
          <li>כמה החזר חודשי הבית באמת יכול לשאת</li>
          <li>בניית תמהיל והשוואה בין הצעות הבנקים</li>
          <li>מחזור משכנתא קיימת, כשההחזר חונק</li>
        </ul>
        <div class="am-actions">
          <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/')); ?>">כל מה שחשוב לדעת על משכנתא <?php echo $arrow; ?></a>
          <a class="am-btn am-btn-on-dark" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לשיחת ייעוץ משכנתא</a>
        </div>
      </div>
      <div class="am-mortgage-side">
        <?php amichai_cert_figure('mortgage', 'am-cert-wide am-cert-on-dark'); ?>
        <blockquote class="am-pull">
          <p>ואז הגיעה הפגישה השנייה וגילינו לתדהמתנו שאנו יכולים לחסוך 260,000 ₪ במשכנתא, ובנוסף להגשים את כל היעדים שהגדרנו.</p>
          <footer><a href="<?php echo esc_url(home_url('/הסיפור-של-משפחת-סלומון-מהשרון/')); ?>">משפחת סלומון מהשרון</a></footer>
        </blockquote>
      </div>
    </div>
  </section>

  <section class="am-mtopics" aria-labelledby="am-mtopics-title">
    <div class="am-wrap">
      <header class="am-sec-head am-sec-head-start am-sec-head-row">
        <div>
          <p class="am-kicker">נושאי משכנתא</p>
          <h2 id="am-mtopics-title">ייעוץ משכנתא לפי המצב שלכם</h2>
        </div>
        <a class="am-letters-all" href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/')); ?>">המדריך המלא למשכנתא</a>
      </header>
      <?php amichai_mortgage_map(); ?>
    </div>
  </section>

  <section class="am-growth" aria-labelledby="am-growth-title">
    <div class="am-wrap am-growth-grid">
      <div class="am-growth-copy">
        <p class="am-kicker">צמיחה</p>
        <h2 id="am-growth-title">חסכונות, השקעות ויעדים</h2>
        <p>לכולנו יש תכניות: להחליף רכב, לשפץ, השכלה לילדים, עזרה בדיור. בלי חיסכון מראש נשארות שתי אפשרויות: לוותר על התכנית, או לממן אותה בהלוואות ולשלם עליה כפול.</p>
        <p>בייעוץ בודקים מה קורה היום לכסף שכבר נחסך, ובונים תוכנית חיסכון שמאפשרת לממש את היעדים בזמן.</p>
        <p class="am-more"><a href="<?php echo esc_url(home_url('/חסכונות/')); ?>">צמיחה, חסכונות והשקעות</a></p>
      </div>
      <ol class="am-questions">
        <li>
          <strong>איפה הכסף מושקע, ואיזו תשואה מתקבלת?</strong>
          <span>כסף שיושב בבנק מניב לרוב תשואה ריאלית שלילית. כלומר, מפסידים.</span>
        </li>
        <li>
          <strong>מה רמת הסיכון?</strong>
          <span>תשואה נאה יכולה להסתיר מנהל תיק שלוקח סיכונים על חשבונכם.</span>
        </li>
        <li>
          <strong>האם הסכום מתאים ליעדים?</strong>
          <span>אחרת, כשהילד ירצה ללמוד באוניברסיטה, יתברר שיש רק שליש מהסכום.</span>
        </li>
      </ol>
    </div>
    <div class="am-wrap">
      <div class="am-growth-links">
        <a href="<?php echo esc_url(home_url('/חיסכון-לכל-ילד-כל-המידע-ומה-כדאי-לעשות/')); ?>"><strong>חיסכון לכל ילד</strong><span>איזה מסלול לבחור, ומה כדאי לעשות</span></a>
        <a href="<?php echo esc_url(home_url('/פנסיה/')); ?>"><strong>פנסיה</strong><span>הנכס הפיננסי הגדול שיהיה לכם בחיים</span></a>
        <a href="<?php echo esc_url(home_url('/מחשבון-חיסכון-משפחתי-ליעדים/')); ?>"><strong>מחשבון חיסכון ליעדים</strong><span>כמה לחסוך בחודש כדי להגיע ליעד</span></a>
      </div>
    </div>
  </section>

  <section class="am-journey" aria-labelledby="am-journey-title">
    <div class="am-wrap">
      <header class="am-sec-head">
        <p class="am-kicker">התהליך</p>
        <h2 id="am-journey-title">איך מתנהל הליווי</h2>
        <p>שלוש פגישות בונות את התוכנית. אחריהן מתחיל החלק שעושה את ההבדל: ליווי צמוד לאורך חודשים, עד שהמשפחה מתנהלת בביטחון ובעצמאות.</p>
      </header>
      <ol class="am-journey-steps">
        <li>
          <span class="am-step-label">פגישה ראשונה</span>
          <h3><a href="<?php echo esc_url(home_url('/פגישה-מס-1-היכרות/')); ?>">היכרות</a></h3>
          <p>כשעה וחצי. הסיפור המשפחתי, המסמכים, הנכסים, ההתחייבויות והיעדים.</p>
        </li>
        <li>
          <span class="am-step-label">פגישה שנייה</span>
          <h3><a href="<?php echo esc_url(home_url('/פגישה-מס-2-הצגת-התוכנית/')); ?>">הצגת התוכנית</a></h3>
          <p>תמונת מצב ברורה, כמה דרכי פעולה, ודוח מסכם שהמשפחה לוקחת הביתה.</p>
        </li>
        <li>
          <span class="am-step-label">פגישה שלישית</span>
          <h3><a href="<?php echo esc_url(home_url('/פגישה-מס-3-יישום-התוכנית/')); ?>">יישום</a></h3>
          <p>מהנייר להתנהלות היומיומית, עם הכלים שסיכמנו עליהם.</p>
        </li>
      </ol>
      <div class="am-support">
        <div class="am-support-track" aria-hidden="true"><span></span></div>
        <div class="am-support-body">
          <span class="am-step-label">ואז, לאורך חודשים</span>
          <h3><a href="<?php echo esc_url(home_url('/ליווי/')); ?>">ליווי צמוד לאורך הדרך</a></h3>
          <ul class="am-support-list">
            <li><strong>שיחה שבועית</strong> על ההתקדמות, עם הכלים שסיכמנו עליהם</li>
            <li><strong>מענה מהיר</strong> לכל שאלה בטלפון או במייל, כשהיא עולה</li>
            <li><strong>פגישות נוספות</strong> כשצריך: משכנתא, החלטה גדולה, שינוי בחיים</li>
          </ul>
        </div>
        <blockquote class="am-support-quote">
          <p>אינני מניח למשפחה שלי עד שאני בטוח שהם צועדים בדרך להצלחה.</p>
          <footer>עמיחי מרקס</footer>
        </blockquote>
      </div>
    </div>
  </section>

  <section class="am-about-sec" id="credentials" aria-labelledby="am-about-title">
    <div class="am-wrap am-about-grid">
      <div class="am-about-copy">
        <p class="am-kicker">נעים להכיר</p>
        <h2 id="am-about-title">15 שנה בליווי משפחות</h2>
        <p>אני עמיחי מרקס. כבר למעלה מעשרים שנה אני פועל במערכת הפיננסית בארץ ובחו״ל, ו־15 שנה אני מלווה משפחות. את 2008 ראיתי מבפנים: שוק שנפל, ואנשים שהפסידו חסכונות ופנסיה בלי להבין למה. מאז, הליווי של משפחות הוא העבודה עצמה, לא תוספת.</p>
        <?php amichai_credentials_list(); ?>
        <p class="am-more"><a href="<?php echo esc_url(home_url('/אודות/')); ?>">הסיפור המלא</a></p>
      </div>
      <div class="am-cert-wall" aria-label="תעודות">
        <?php
        amichai_cert_figure('mortgage', 'am-cert-wide');
        amichai_cert_figure('family');
        amichai_cert_figure('coaching');
        ?>
      </div>
    </div>
  </section>

  <section class="am-letters" aria-roledescription="קרוסלה" aria-labelledby="am-letters-title">
    <div class="am-wrap am-letters-head">
      <div>
        <p class="am-kicker">המלצות</p>
        <h2 id="am-letters-title" class="am-letters-title">מה המשפחות כותבות</h2>
      </div>
      <div class="am-letters-tools">
        <a class="am-letters-all" href="<?php echo esc_url(home_url('/סיפורי-משפחות/')); ?>">כל הסיפורים</a>
        <div class="am-letters-navs">
          <button class="am-letters-btn" type="button" data-dir="-1" aria-label="המכתב הקודם">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="m10 6 6 6-6 6"/></svg>
          </button>
          <button class="am-letters-btn" type="button" data-dir="1" aria-label="המכתב הבא">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="m14 6-6 6 6 6"/></svg>
          </button>
        </div>
      </div>
    </div>
    <div class="am-letters-track" tabindex="0">
      <a class="am-note" href="<?php echo esc_url(home_url('/הסיפור-של-משפחת-אשכול-מהדרום/')); ?>">
        <span class="am-note-sheet">
          <blockquote>
            <p>עשה סדר בנתונים הקיימים, הסביר לנו את המשמעויות, פרש בפנינו אפשרויות לעתיד, הנחה אותנו בבניית תכנית פעולה. ומלווה אותנו. כן, עדיין, הדרך ארוכה היא ורבה.</p>
          </blockquote>
          <span class="am-note-sign">משפחת אשכול מהדרום</span>
        </span>
      </a>
      <a class="am-note" href="<?php echo esc_url(home_url('/המלצה/')); ?>">
        <span class="am-note-sheet">
          <blockquote>
            <p>בעזרת הליווי הרגיש והצמוד שלך הצלחנו לצאת לדרך חדשה, דרך אותה בנית עבורנו כעבודת אומן, מותאמת לצרכינו ולערכינו. כיום אנו כבר רואים תוצאות ומצליחים לשמר אותן לאורך זמן.</p>
          </blockquote>
          <span class="am-note-sign">ערן ושרון</span>
        </span>
      </a>
      <a class="am-note" href="<?php echo esc_url(home_url('/הסיפור-של-משפחת-אקשטיין-מהצפון/')); ?>">
        <span class="am-note-sheet">
          <blockquote>
            <p>גילינו שאנחנו יכולים עם מעט הכסף שיש לנו לעשות הרבה יותר, וגם לקנות בית. היום אנחנו בהליכי קנייה של בית משלנו, ואנחנו יודעים שנעמוד בזה.</p>
          </blockquote>
          <span class="am-note-sign">משפחת אקשטיין מהצפון</span>
        </span>
      </a>
      <a class="am-note" href="<?php echo esc_url(home_url('/מכתב-תודה-לעמיחי-טלי-וחנן/')); ?>">
        <span class="am-note-sheet">
          <blockquote>
            <p>למדנו לנהל תקציב משפחתי נכון ומאוזן, למדנו מהי תודעה עשירה, וכך הרכבנו תקציב נכון וטוב שהביא אותנו לצמיחה ממשית. אנו מצליחים לנהל את כספנו בחוכמה, ולא שהבנק ינהל אותנו.</p>
          </blockquote>
          <span class="am-note-sign">טלי וחנן, משפחת בר-און</span>
        </span>
      </a>
    </div>
    <div class="am-letters-dots" role="group" aria-label="בחירת מכתב">
      <button type="button" aria-label="משפחת אשכול" aria-current="true"></button>
      <button type="button" aria-label="ערן ושרון"></button>
      <button type="button" aria-label="משפחת אקשטיין"></button>
      <button type="button" aria-label="טלי וחנן, משפחת בר-און"></button>
    </div>
  </section>

  <section class="am-media-sec" aria-labelledby="am-media-title">
    <div class="am-wrap">
      <header class="am-sec-head am-sec-head-start">
        <p class="am-kicker">תקשורת</p>
        <h2 id="am-media-title">בטלוויזיה וברדיו</h2>
      </header>
      <div class="am-media-grid">
        <a class="am-media-card" href="<?php echo esc_url(home_url('/מן-התקשורת/')); ?>">
          <span class="am-media-thumb"><img src="<?php echo esc_url(amichai_asset('assets/images/tv-10311.webp')); ?>" width="540" height="305" loading="lazy" alt="עמיחי מרקס בתוכנית לבחור נכון"><span class="am-play" aria-hidden="true"></span></span>
          <strong>כך תנהלו טוב יותר את ההוצאות המשפחתיות</strong>
          <span>«לבחור נכון» בהנחיית מיכל צפיר</span>
        </a>
        <a class="am-media-card" href="<?php echo esc_url(home_url('/מן-התקשורת/')); ?>">
          <span class="am-media-thumb"><img src="<?php echo esc_url(amichai_asset('assets/images/tv-10322.webp')); ?>" width="540" height="305" loading="lazy" alt="עמיחי מרקס באולפן לבחור נכון"><span class="am-play" aria-hidden="true"></span></span>
          <strong>קטעים נבחרים מהאולפן</strong>
          <span>«לבחור נכון» בהנחיית מיכל צפיר</span>
        </a>
        <a class="am-media-card am-media-radio" href="<?php echo esc_url(home_url('/מן-התקשורת/')); ?>">
          <span class="am-media-thumb"><img src="<?php echo esc_url(amichai_asset('assets/images/kol-barama.webp')); ?>" width="800" height="497" loading="lazy" alt="קול ברמה"></span>
          <strong>חזרה לשגרה, והמינוס שנשאר</strong>
          <span>«דנה בסוגיה» עם שיפי חריטן, קול ברמה</span>
        </a>
      </div>
    </div>
  </section>

  <section class="am-reads" aria-labelledby="am-reads-title">
    <div class="am-wrap">
      <header class="am-sec-head am-sec-head-start am-sec-head-row">
        <div>
          <p class="am-kicker">מהבלוג</p>
          <h2 id="am-reads-title">מאמרים נבחרים</h2>
        </div>
        <a class="am-letters-all" href="<?php echo esc_url(home_url('/מאמרים/')); ?>">לכל המאמרים</a>
      </header>
      <div class="am-topic-grid">
        <?php
        foreach (['ניהול-תקציב-משפחתי', 'איך-לצאת-מהמינוס', 'יעוץ-פיננסי-משפחתי-למה-מיועד-הייעוץ'] as $slug) {
            $post = amichai_post_by_slug($slug);
            if ($post) {
                amichai_topic_card($post);
            }
        }
        ?>
      </div>
    </div>
  </section>

  <section class="am-faq-sec">
    <div class="am-wrap am-faq">
      <p class="am-kicker">שאלות ותשובות</p>
      <h2>שאלות נפוצות</h2>
      <details>
        <summary>כמה פגישות יש, ומה קורה אחריהן?</summary>
        <p>שלוש פגישות: היכרות של כשעה וחצי, הצגת התוכנית, ויישום. אחריהן מתחיל ליווי צמוד לאורך חודשים, עם שיחה שבועית ומענה לכל שאלה בדרך, עד שיש ביטחון להמשיך לבד.</p>
      </details>
      <details>
        <summary>אתה גם יועץ משכנתאות?</summary>
        <p>כן. אני יועץ משכנתאות וחבר בהתאחדות יועצי המשכנתאות בישראל. המשכנתא נבנית מתוך התמונה הכלכלית המלאה של הבית, ולא כעסקה נפרדת מול הבנק. <a href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/')); ?>">עוד על ייעוץ משכנתאות</a>.</p>
      </details>
      <details>
        <summary>הייעוץ עוסק גם בחסכונות ובהשקעות?</summary>
        <p>כן. בודקים איפה החסכונות מושקעים, באיזו רמת סיכון ובאילו דמי ניהול, ובונים תוכנית חיסכון לפי היעדים: לימודים, דיור לילדים, רכב או פרישה.</p>
      </details>
      <details>
        <summary>כדאי להגיע גם אם אין מינוס?</summary>
        <p>כן. הליווי מתאים גם למי שמרוויח יפה ועדיין אין לו תמונה של הפנסיה, הביטוחים, החסכונות והיעדים.</p>
      </details>
      <details>
        <summary>נבדקים גם הביטוחים והפנסיה?</summary>
        <p>כן. באותו תהליך נבדקים הביטוחים, כפל כיסויים ודמי הניהול בפנסיה, לצד ההתנהלות השוטפת בבית.</p>
      </details>
      <details>
        <summary>מה הניסיון וההסמכות של עמיחי מרקס?</summary>
        <p>15 שנה בליווי משפחות ומעל 20 שנה בעולם הפיננסי, בארץ ובחו״ל. יועץ משכנתאות וחבר בהתאחדות יועצי המשכנתאות בישראל, הסמכה כיועץ וכמאמן לכלכלת המשפחה, רישיון לייעוץ פנסיוני, והסמכה כמאמן וכמגשר.</p>
      </details>
    </div>
  </section>

  <?php amichai_closing_cta(); ?>
</main>
<?php
get_footer();
