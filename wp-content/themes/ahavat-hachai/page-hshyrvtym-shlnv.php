<?php
/**
 * Template Name: השירותים שלנו
 */
get_header();
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
?>
<section class="page-plain">
    <header class="section-head">
        <h1 class="heading-split"><strong class="heading-split__pink">השירותים</strong> <span class="heading-split__dark">שלנו</span></h1>
        <p>במרפאה ניתנים שירותי רפואה שוטפת, חיסונים בדיקות שגרה וטיפולי מניעה. מעבר לשירותים הרפואיים - טיפולים אלטרנטיבים, יעוץ תזונתי מכירת ציוד נלווה ומספרה.</p>
    </header>
    <div class="service-grid">
        <?php foreach ($services as $s) : ?>
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
<?php
get_footer();
