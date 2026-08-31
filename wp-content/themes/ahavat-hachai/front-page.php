<?php
/**
 * Homepage — matches ofervet.co.il layout and copy.
 */
get_header();
?>
<section class="hero hero--home">
    <img class="hero__bg" src="<?php echo esc_url(ahavat_img('hero_home')); ?>" alt="ברוכים הבאים לאהבת החי, מרכז וטרינרי" width="1920" height="900" />
    <aside class="hero-card hero-card--magenta">
        <ul class="vet-list">
            <li>
                <h3>ד״ר עופר שביט</h3>
                <p>כירורגיה, אורתופדיה ואונקולוגיה</p>
            </li>
            <li>
                <h3>ד״ר אלינה שיינר</h3>
                <p>כירורגיה ופנימית</p>
            </li>
            <li>
                <h3>ד״ר אסתי זיו</h3>
                <p>רפואת חיות אקזוטיות</p>
            </li>
            <li>
                <h3>אורלי זכאי</h3>
                <p>רפואה סינית</p>
            </li>
        </ul>
    </aside>
</section>

<section class="welcome">
    <div class="welcome__text">
        <?php ahavat_two_tone('ברוכים', 'הבאים', 'h1', 'heading-split heading-split--welcome', true); ?>
        <div class="welcome__copy">
            <p>מרכז וטרינרי אהבת החי פועל כבר מעל 30 שנה בצפון תל אביב.</p>
            <p>המרפאה מצוידת בציוד החדיש והמשוכלל ביותר ומעניקה את מיטב השירותים הרפואיים לחיות המחמד.</p>
            <p>אנו מקפידים על יחס חם ואוהב לחיות המטופלות במרפאה (גם לבעלים שלהן)</p>
        </div>
        <?php ahavat_btn_icon(ahavat_whatsapp_url(), 'כתבו לנו', 'icon_whatsapp_white', 'outline'); ?>
    </div>
    <div class="welcome__slider slider" data-slider>
        <div class="slider__track">
            <div class="slider__slide is-active" style="background-image:url('<?php echo esc_url(ahavat_img('welcome_1')); ?>')"></div>
            <div class="slider__slide" style="background-image:url('<?php echo esc_url(ahavat_img('welcome_2')); ?>')"></div>
            <div class="slider__slide" style="background-image:url('<?php echo esc_url(ahavat_img('welcome_3')); ?>')"></div>
        </div>
        <button class="slider__prev" type="button" aria-label="שקופית קודמת"></button>
        <button class="slider__next" type="button" aria-label="שקופית הבאה"></button>
        <div class="slider__dots"></div>
    </div>
</section>

<section class="services" id="services">
    <header class="section-head">
        <?php ahavat_two_tone('השירותים', 'שלנו'); ?>
        <p>במרפאה ניתנים שירותים מגוונים מעבר לשירותים הרפואיים - טיפולים אלטרנטיבים, יעוץ תזונתי מכירת ציוד נלווה ומספרה.</p>
    </header>
    <div class="service-grid">
        <?php
        $services = [
            ['מנוי שנתי למרפאה', 'המזכה את המנוי בחיסונים וביקורים חינם ללא הגבלה והנחות על טיפולים, פרוצדורות רפואיות, תרופות ומזון.', 'icon_calendar'],
            ['רפואת חיות אקזוטיות- חדש במרפאה', 'הצטרפה אלינו ד״ר אסתי זיו , רופאה לחיות אקזוטיות, מכרסמים, זוחלים, בעלי כנף וחמוסים', 'icon_iguana'],
            ['כירורגיה רנטגן ואולטרסאונד', 'במרפאה חדר ניתוח המצויד במיטב המכשור. אנו מבצעים צילומי רנטגן ובדיקות אולטרסאונד עם הציוד החדיש ביותר', 'icon_cat'],
            ['אשפוז יום', 'אשפוזים וטיפולי יום ממושכים', 'icon_monitor'],
            ['שירותי מעבדה', 'במרפאה שלנו ישנה מעבדה משוכללת המייצרת תשובות במקום תוך 20 דקות!', 'icon_microscope'],
            ['טיפולי שיניים', 'ניקוי אבן שן, עקירות וטיפול בדלקות חניכיים.', 'icon_tooth'],
            ['מספרת כלבים', 'מספרה מקצועית המציעה תספורות גזע, תספורות ביתיות טיפוחים ורחצות בכל עונות השנה', 'icon_grooming'],
            ['רפואה אלטרנטיבית', 'רפואה הוליסטית אלטרנטיבית, דיקור, והומאופטיה.', 'icon_hands'],
            ['שרותי מומחה במקום', 'רפואה פנימית, ניורולוג, קרדיולוג ועוד', 'icon_docbag'],
        ];
        foreach ($services as $s) :
        ?>
            <article class="service-card">
                <div>
                    <h2><?php echo esc_html($s[0]); ?></h2>
                    <p><?php echo esc_html($s[1]); ?></p>
                </div>
                <img src="<?php echo esc_url(ahavat_img($s[2])); ?>" alt="" width="45" height="45" />
            </article>
        <?php endforeach; ?>
    </div>
    <div class="section-cta">
        <?php ahavat_btn_icon('tel:' . AHAVAT_PHONE_TEL, 'דברו איתנו', 'icon_phone_w', 'pink'); ?>
    </div>
</section>

<section class="updates">
    <?php ahavat_two_tone('עדכונים', 'מהמרפאה'); ?>
    <div class="updates__grid">
        <article class="update-card">
            <div>
                <h2>חדש! רפואת חיות אקזוטיות</h2>
                <p>נוספה לצוות שלנו רופאה לחיות אקזוטיות- ד״ר אסתי זיו- מטפלת בארנבונים, מכרסמים, בעלי כנף, חמוסים וזוחלים. <strong>ברוכה הבאה אסתי!</strong></p>
                <p>למאמרים של ד״ר זיו:</p>
                <p><a href="<?php echo esc_url(home_url('/mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym/')); ?>"><strong>ארנבים - שינויים בהתנהגות</strong></a></p>
                <p><a href="<?php echo esc_url(home_url('/articles/mel-imichel--a-pair-of-hamsters/')); ?>"><strong>אוגרים- איך מגדלים אוגרים באותו הכלוב</strong></a></p>
            </div>
            <img src="<?php echo esc_url(ahavat_img('icon_iguana')); ?>" alt="" width="72" height="72" />
        </article>
        <article class="update-card">
            <div>
                <h2>שדרגנו את שירותי החרום שלנו</h2>
                <p>אנחנו עובדים בשיתוף פעולה עם ״וט- אדום ״- חברה בין לאומית המתמחה במקרי חירום בבית הלקוח. לחברה נסיון עשיר במתן שירותי חירום בבית הלקוח באירופה ועכשיו גם בישראל.</p>
                <p>הוטרינרים של ״וט- אדום״ פועלים במשך הלילה וסופי שבוע ומעניקים מענה רפואי ובמידת הצורך מגיעים לבית הלקוח.</p>
                <p>כל מקרה המטופל על ידי הצוות מדווח אלינו להמשך טיפול על פי הצורך, שיתוף הפעולה הינו רציף כך שאנחנו שותפים ומעודכנים במצבו של בעל החיים ובתהליך קבלת ההחלטות הרפואיות</p>
                <p class="update-card__highlight">מנויי המרפאה זכאים להנחה של 10% מדמי הביקור</p>
                <p>לקבלת השירות במקרה חירום מחוץ לשעות העבודה</p>
                <p><a class="phone-lg" href="tel:<?php echo esc_attr(AHAVAT_EMERGENCY_HOME_TEL); ?>"><?php echo esc_html(AHAVAT_EMERGENCY_HOME_DISPLAY); ?></a></p>
            </div>
            <img src="<?php echo esc_url(ahavat_img('icon_ambulance')); ?>" alt="" width="72" height="72" />
        </article>
    </div>
</section>

<section class="contest-call" id="photo-contest">
    <?php ahavat_two_tone('תחרות צילום 2025', 'יוצאת לדרך'); ?>
    <div class="contest-call__layout">
        <img src="<?php echo esc_url(ahavat_img('contest_call')); ?>" alt="תחרות צילום אהבת החי" width="712" height="480" loading="lazy" />
        <div>
            <p><strong>מקום ראשון</strong> - זוכה במנוי שנתי למרפאה חינם לבעל החיים המצולם</p>
            <p><strong>מקום שני ושלישי זוכים</strong> בהדפסת של הצילום על גבי לוקובונד- אלומיניום</p>
            <p>עשרת המקומות הראשונים יזכו לקשט את קירות המרפאה בתמונות הנבחרות</p>
            <p>שילחו עד שלוש תמונות מהממות באיכות גבוהה למייל <a href="mailto:<?php echo esc_attr(AHAVAT_EMAIL_OFFICE); ?>"><strong><?php echo esc_html(AHAVAT_EMAIL_OFFICE); ?></strong></a> או לוואטסאפ <a href="<?php echo esc_url(ahavat_whatsapp_url()); ?>"><strong>053-3535306</strong></a></p>
            <div class="fine-print">
                <p>האותיות הקטנות:</p>
                <ul>
                    <li>יש לרשום את שמכם ואת שם חיית המחמד שלכם</li>
                    <li>קובץ קטן או מפוקסל ימנע את הגדלת הצילום ויפסול את התמונה</li>
                    <li>צילומים מקצועיים לא יוכלו להשתתף בתחרות</li>
                    <li>בעוד שישה שבועות צוות השופטים יכריז על הזוכים המאושרים</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="home-team">
    <header class="section-head">
        <?php ahavat_two_tone('הצוות', 'שלנו'); ?>
        <p>אין על הצוות שלנו בעולם.<br />מהמחוייבות הרפואית, המקצועיות, החיוך, האהבה לבעלי החיים שלכם, אנחנו כאן בשבילכם.</p>
    </header>
    <div class="team-grid team-grid--home">
        <?php
        $team = ahavat_team_members(true);
        if ($team->have_posts()) :
            while ($team->have_posts()) :
                $team->the_post();
                get_template_part('template-parts/team', 'card');
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
    <div class="section-cta">
        <?php ahavat_btn(home_url('/our-team/'), 'לקריאה על כל חברי הצוות', 'pink'); ?>
    </div>
</section>

<section class="alt-teaser">
    <div class="alt-teaser__text">
        <?php ahavat_two_tone('רפואה', 'אלטרנטיבית'); ?>
        <p><strong>לפעמים רפואה קונבנציונאלית צריכה חיזוק-</strong><br />אנחנו גאים לעבוד בשיתוף פעולה עם אורלי זכאי, מטפלת מוסמכת ברפואה סינית לבעלי חיים ויועצת להתנהגות חתולים</p>
        <?php ahavat_btn('tel:' . AHAVAT_PHONE_TEL, 'קבע תור לאורלי', 'pink'); ?>
    </div>
    <div class="alt-teaser__photos">
        <img src="<?php echo esc_url(ahavat_img('orly_photo')); ?>" alt="אורלי זכאי" loading="lazy" />
        <img src="<?php echo esc_url(ahavat_img('orly_alt')); ?>" alt="טיפול אלטרנטיבי" loading="lazy" />
    </div>
</section>

<section class="groom-teaser">
    <div class="groom-teaser__text">
        <?php ahavat_two_tone('המספרה', 'שלנו'); ?>
        <p>יש לנו מספרת כלבים מקצועית- תספורות ביתיות, תספורות גזע וטיפוח - הכל נעשה באהבה וסבלנות על ידי שגיא הספר שלנו</p>
        <div class="btn-row">
            <?php ahavat_btn(home_url('/grooming/'), 'קרא עוד על המספרה', 'outline'); ?>
            <?php ahavat_btn('tel:' . AHAVAT_PHONE_TEL, 'קבע תור למספרה', 'pink'); ?>
        </div>
    </div>
    <div class="groom-teaser__photos">
        <img src="<?php echo esc_url(ahavat_img('sagi_dog')); ?>" alt="כלב אחרי טיפוח" loading="lazy" />
        <img src="<?php echo esc_url(ahavat_img('sagi_groomer')); ?>" alt="שגיא הספר" loading="lazy" />
    </div>
</section>

<section class="clinic-teaser">
    <div class="clinic-teaser__card">
        <h2 class="heading-split"><strong class="heading-split__pink">המרפאה</strong> <span class="heading-split__dark">שלנו</span></h2>
        <p>אנו גאים להיות מובילי דרך בכל הקשור לחדשנות ומצויינות רפואית.</p>
        <p>המעבדה, הרנטגן, האולטרסאונד ושאר המכשור הרפואי הוא מהחדשים והמתקדמים בעולם.</p>
        <?php ahavat_btn(home_url('/our-clinic/'), 'לסיור במרפאה', 'pink'); ?>
    </div>
    <div class="clinic-teaser__slider slider" data-slider>
        <div class="slider__track">
            <div class="slider__slide is-active" style="background-image:url('<?php echo esc_url(ahavat_img('clinic_teaser_1')); ?>')"></div>
            <div class="slider__slide" style="background-image:url('<?php echo esc_url(ahavat_img('clinic_teaser_2')); ?>')"></div>
        </div>
    </div>
</section>

<section class="winners">
    <header class="section-head">
        <?php ahavat_two_tone('תחרות צילום', '2025'); ?>
        <p>כמדי שנה ערכנו תחרות צילום בין הלקוחות שלנו</p>
        <p class="text-pink">עשרת המקומות הראשונים הודפסו ומעטרים את קירות המרפאה !</p>
        <p>שלושת המקומות הראשונים זכו בפרסים שווים במיוחד!</p>
    </header>
    <div class="winners__grid">
        <article class="winner">
            <div class="winner__photo" style="background-image:url('<?php echo esc_url(ahavat_img('winner_1')); ?>')"></div>
            <div class="winner__meta">
                <h2><img src="<?php echo esc_url(ahavat_img('icon_star')); ?>" alt="" /> מקום ראשון</h2>
                <h3>מנוי שנתי לשני החתולים מתנה ותהילת עולמים</h3>
                <p>ברכות לקורה וקטרה של שלי אבידור</p>
            </div>
        </article>
        <article class="winner">
            <div class="winner__photo" style="background-image:url('<?php echo esc_url(ahavat_img('winner_2')); ?>')"></div>
            <div class="winner__meta">
                <h2><img src="<?php echo esc_url(ahavat_img('icon_star')); ?>" alt="" /> מקום שני</h2>
                <h3>תמונה מודפסת על קנווס מתנה והערכה רבה</h3>
                <p>ברכות לג׳יי המלך של דניאל בירן</p>
            </div>
        </article>
        <article class="winner">
            <div class="winner__photo" style="background-image:url('<?php echo esc_url(ahavat_img('winner_3')); ?>')"></div>
            <div class="winner__meta">
                <h2><img src="<?php echo esc_url(ahavat_img('icon_star')); ?>" alt="" /> מקום שלישי</h2>
                <h3>תמונה מודפסת על קנווס מתנה, אהבה וליטופים</h3>
                <p>ברכות לנמו של תומר לניר</p>
            </div>
        </article>
    </div>
</section>
<?php
get_footer();
