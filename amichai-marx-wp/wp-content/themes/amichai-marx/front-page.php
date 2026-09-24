<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main">
  <section class="am-hero">
    <div class="am-wrap am-hero-grid">
      <div>
        <h1>ייעוץ לכלכלת המשפחה<br><span>וביטחון פיננסי</span></h1>
        <p class="am-lead">מעל 20 שנות ניסיון בליווי משפחות לצמיחה ותכנון נכון</p>
        <div class="am-actions">
          <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ <span aria-hidden="true">←</span></a>
          <a class="am-btn am-btn-ghost" href="tel:054-2372417">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11.4 11.4 0 0 0 .57 3.6 1 1 0 0 1-.25 1L6.6 10.8z"/></svg>
            חייגו עכשיו
          </a>
        </div>
        <div class="am-trust">
          <article>
            <div class="am-ico" aria-hidden="true">
              <svg viewBox="0 0 48 48" width="46" height="46"><path d="M24 6 10 12v12c0 9 6 15 14 18 8-3 14-9 14-18V12L24 6z" fill="none" stroke="#1d4f8c" stroke-width="2.4"/><path d="m17 24 5 5 10-11" fill="none" stroke="#1faa63" stroke-width="2.6" stroke-linecap="round"/></svg>
            </div>
            מעל 20 שנות<br>ניסיון פיננסי
          </article>
          <article>
            <div class="am-ico" aria-hidden="true">
              <svg viewBox="0 0 48 48" width="46" height="46"><circle cx="16" cy="16" r="5" fill="none" stroke="#1d4f8c" stroke-width="2.2"/><circle cx="32" cy="16" r="5" fill="none" stroke="#1d4f8c" stroke-width="2.2"/><path d="M6 36c1.5-6 5-9 10-9s8.5 3 10 9M22 36c1.2-5 4.2-8 8-8 4 0 7 3 8.5 8" fill="none" stroke="#1faa63" stroke-width="2.2" stroke-linecap="round"/></svg>
            </div>
            ליווי אישי מותאם<br>למשפחה
          </article>
          <article>
            <div class="am-ico" aria-hidden="true">
              <svg viewBox="0 0 48 48" width="46" height="46"><circle cx="24" cy="24" r="14" fill="none" stroke="#1d4f8c" stroke-width="2.2"/><circle cx="24" cy="24" r="8" fill="none" stroke="#1d4f8c" stroke-width="2.2"/><circle cx="24" cy="24" r="2.5" fill="#1faa63"/></svg>
            </div>
            תכנון תקציב<br>ויעדים
          </article>
        </div>
      </div>
      <div class="am-portrait-wrap">
        <img class="am-portrait" src="<?php echo esc_url(amichai_asset('assets/images/portrait.jpg')); ?>" width="236" height="314" alt="עמיחי מרקס, יועץ לכלכלת המשפחה">
      </div>
    </div>
  </section>

  <section class="am-section">
    <div class="am-wrap">
      <div class="am-section-head">
        <p class="am-kicker">השירות</p>
        <h2>ליווי לכלכלת הבית, לא הרצאה כללית</h2>
        <p>עמיחי מרקס יושב עם המשפחה, ממפה את המספרים ואת הסיפור שמאחוריהם, ובונה תוכנית שאפשר לחיות איתה. מתאים גם למי שנמצא במינוס וגם למי שמרוויח יפה ועדיין אין לו תמונה מסודרת.</p>
      </div>
      <div class="am-cards">
        <a class="am-card" href="<?php echo esc_url(home_url('/ניהול-תקציב-משפחתי/')); ?>"><h3>ניהול תקציב</h3><p>הכנסות מול הוצאות, בלי לנחש לאן נעלם החודש.</p></a>
        <a class="am-card" href="<?php echo esc_url(home_url('/איך-לצאת-מהמינוס/')); ?>"><h3>יציאה מהמינוס</h3><p>מינוס הוא הלוואה יקרה. יש סדר פעולות לצאת ממנו.</p></a>
        <a class="am-card" href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/')); ?>"><h3>דיור ומשכנתאות</h3><p>שכירות או קנייה, תמהיל, ומחיר אמיתי של הקפאה.</p></a>
        <a class="am-card" href="<?php echo esc_url(home_url('/פנסיה/')); ?>"><h3>פנסיה וביטוחים</h3><p>דמי ניהול, כפל כיסויים, ומה באמת יחכה בגיל פרישה.</p></a>
        <a class="am-card" href="<?php echo esc_url(home_url('/חסכונות/')); ?>"><h3>חסכונות ויעדים</h3><p>לחסוך מראש לחתונה, ללימודים או לכרית ביטחון.</p></a>
        <a class="am-card" href="<?php echo esc_url(home_url('/הרצאות-וסדנאות/')); ?>"><h3>הרצאות וסדנאות</h3><p>מפגשים לארגונים וקהילות, כולל קורס התנהלות.</p></a>
      </div>
    </div>
  </section>

  <section class="am-section am-soft">
    <div class="am-wrap">
      <div class="am-section-head">
        <p class="am-kicker">התהליך</p>
        <h2>שלוש פגישות, ואחר כך ליווי</h2>
        <p>כך מתואר התהליך בעמודי הפגישות באתר. לא קורס אחיד לכל משפחה.</p>
      </div>
      <div class="am-steps">
        <article class="am-step">
          <div class="am-step-num">1</div>
          <h3>היכרות</h3>
          <p>כשלוש שעות. הסיפור המשפחתי, המסמכים, הנכסים, ההתחייבויות והיעדים.</p>
          <a href="<?php echo esc_url(home_url('/פגישה-מס-1-היכרות/')); ?>">פגישה ראשונה</a>
        </article>
        <article class="am-step">
          <div class="am-step-num">2</div>
          <h3>הצגת התוכנית</h3>
          <p>תמונת מצב, כמה חלופות, ובחירה משותפת. המשפחה מקבלת דוח מסכם.</p>
          <a href="<?php echo esc_url(home_url('/פגישה-מס-2-הצגת-התוכנית/')); ?>">פגישה שנייה</a>
        </article>
        <article class="am-step">
          <div class="am-step-num">3</div>
          <h3>יישום</h3>
          <p>מהנייר להתנהלות היומיומית, עם כלים שעובדים בבית הזה.</p>
          <a href="<?php echo esc_url(home_url('/פגישה-מס-3-יישום-התוכנית/')); ?>">פגישה שלישית</a>
        </article>
        <article class="am-step">
          <div class="am-step-num">4</div>
          <h3>ליווי</h3>
          <p>שאלות בדרך ושיחה שבועית, עד שיש ביטחון להמשיך לבד.</p>
          <a href="<?php echo esc_url(home_url('/ליווי/')); ?>">איך נראה הליווי</a>
        </article>
      </div>
    </div>
  </section>

  <section class="am-section">
    <div class="am-wrap">
      <div class="am-section-head">
        <p class="am-kicker">במילים של משפחות</p>
        <h2>המלצות שפורסמו באתר</h2>
        <p>הציטוטים לקוחים כלשונם מהמכתבים שבאתר. בלי מספרים שלא נאמרו שם.</p>
      </div>
      <div class="am-quotes">
        <article class="am-quote">
          <blockquote>״לאחר הייעוץ הרגשנו שעולם השפע נפתח לנו, בעזרת הליווי הרגיש והצמוד שלך הצלחנו לצאת לדרך חדשה… כיום אנו כבר רואים תוצאות ומצליחים לשמר אותן לאורך זמן.״</blockquote>
          <cite>ערן ושרון · <a href="<?php echo esc_url(home_url('/המלצה/')); ?>">המכתב המלא</a></cite>
        </article>
        <article class="am-quote">
          <blockquote>״למדנו לנהל תקציב משפחתי נכון ומאוזן, למדנו מהי תודעה עשירה… נתת לנו ביטחון לעתיד טוב יותר, אנו מצליחים לנהל את כספנו בחוכמה ולא שהבנק ינהל אותנו.״</blockquote>
          <cite>טלי וחנן · <a href="<?php echo esc_url(home_url('/מכתב-תודה-לעמיחי-טלי-וחנן/')); ?>">מכתב התודה</a></cite>
        </article>
        <article class="am-quote">
          <blockquote>״הקהל שיבח והרעיף מחמאות על הפרקטיות של ההרצאה כמו גם על אופן העברתה… ממליצה בכל פה על ההרצאה.״</blockquote>
          <cite>פנינה שלומיוק, מנהלת הספרייה הציבורית אזור · <a href="<?php echo esc_url(home_url('/המלצה-מפנינה-שלומיוק-מנהלת-הספרייה/')); ?>">ההמלצה</a></cite>
        </article>
      </div>
      <p style="margin-top:18px"><a href="<?php echo esc_url(home_url('/סיפורי-משפחות/')); ?>">לסיפורי המשפחות</a></p>
    </div>
  </section>

  <section class="am-section am-soft">
    <div class="am-wrap">
      <div class="am-section-head">
        <p class="am-kicker">כלי עזר</p>
        <h2>אפשר להתחיל מהמספרים</h2>
      </div>
      <div class="am-tool-grid">
        <article class="am-card">
          <h3>מחשבון תקציב משפחתי</h3>
          <p>הכנסות, הוצאות קבועות והוצאות משתנות. יתרה חודשית ויחס הוצאות להכנסות.</p>
          <a class="am-btn am-btn-ghost" href="<?php echo esc_url(home_url('/מחשבון-תקציב-משפחתי/')); ?>">למחשבון</a>
        </article>
        <article class="am-card">
          <h3>מחשבון חיסכון ליעדים</h3>
          <p>כמה להפקיד בחודש כדי לעמוד ביעדים, בהפקדה קבועה או דינמית. כלי המחשה, לא ייעוץ אישי.</p>
          <a class="am-btn am-btn-ghost" href="<?php echo esc_url(home_url('/מחשבון-חיסכון-משפחתי-ליעדים/')); ?>">למחשבון</a>
        </article>
      </div>
    </div>
  </section>

  <section class="am-section">
    <div class="am-wrap">
      <div class="am-section-head">
        <p class="am-kicker">מהבלוג</p>
        <h2>קריאה להמשך</h2>
      </div>
      <div class="am-posts">
        <?php
        $q = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 3,
            'ignore_sticky_posts' => true,
        ]);
        if ($q->have_posts()) :
            while ($q->have_posts()) :
                $q->the_post();
                ?>
                <article class="am-post">
                  <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j.n.Y')); ?></time>
                  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?></p>
                </article>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <section class="am-section" style="padding-top:0">
    <div class="am-wrap">
      <div class="am-cta-band">
        <div>
          <h2>מוכנים לעשות סדר?</h2>
          <p>שיחת היכרות קצרה, בלי התחייבות. 054-2372417.</p>
        </div>
        <a class="am-btn am-btn-primary" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
