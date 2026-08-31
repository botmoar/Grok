<?php
/**
 * Template Name: המרפאה
 */
get_header();
$rooms = [
    [
        'title' => 'חדר קבלה',
        'text' => [
            'ברוכים הבאים, אנחנו מאוד שמחים שהגעתם. יש לנו במרפאה שתי פינות המתנה, פינת המתנה לחתולים ופינת המתנה לכלבים, כדי למנוע לחץ מיותר לשני הצדדים',
            'בעמדת הקבלה תישאלו לסיבת ההגעה, תתבקשו להישקל (לא אתם, חיית המחמד שלכם) ומיד אחד מהוטרינרים שלנו יתפנה לטפל בכם.',
        ],
        'images' => ['66a3bee56aa62df0d49b5383_Liat_on_the_reception.jpg', '66a3bef405de1689d193bb13_cat_waiting_room.jpg', '66a3befa3a2e5c3dec728ec1_reception_.jpg'],
    ],
    [
        'title' => 'חדרי בדיקות',
        'text' => ['יש לנו במרפאה שני חדרי בדיקות המצוידים בכל הנדרש, כדי להבטיח את את הטיפול הטוב ביותר עבור חיית המחמד שלכם.'],
        'images' => ['6a1abe3e0320e598435e8780_WhatsApp_Image_2026-05-24_at_10.38.51_-2-.jpeg', '65e7037cc2b49bacc1067daa_offer_exam_shitzu-min.JPG', '66a3cb3aa462df2c8b13c83e_Offer_and_Alina_exam_room.jpg'],
    ],
    [
        'title' => 'אולטרסאונד ורנטגן',
        'text' => ['ציוד האולטרסאונד והרנטגן שלנו הוא מהחדשים והמתקדמים בעולם'],
        'images' => ['66a3bee54fde64e4b229ec4b_Offer_and_Alina_watching_rentgen.jpg', '66a3beeceb46c3d05ba3b4b9_Alina_exam_dog.jpg', '668017122d0277bfa0628970_DSC08079-min.JPG'],
    ],
    [
        'title' => 'חדר ניתוח',
        'text' => ['אנחנו מבצעים מגוון רחב של ניתוחים החל מניתוחי עיקור וסרוס ועד לניתוחים אורטופדים וכמובן פרוצדורות שדורשות הרדמה כמו ניקוי או עקירת שיניים.'],
        'images' => ['66804c9f6ba918352b5fdb15_DSC08240-min.JPG', '66804c9fdc96494ebcaaf7ed_DSC08151-min.JPG', '66804c9f91b7842860b0be5a_DSC08205-min.JPG'],
    ],
    [
        'title' => 'מחלקת אישפוז',
        'text' => ['במחלקת האישפוז שלנו מתאוששים אחרי ניתוחים ומתאשפזים לצורך קבלת טיפולים. אנחנו עושים הכל כדי שהמטופלים שלנו יעבורו את ההמתנה בחדר האשפוז בצורה הנעימה ביותר.'],
        'images' => ['66800c8971414a358e24b777_DSC07849-min.JPG', '66a3befa516f8ac9af0f3d98_ishpuz.jpg'],
    ],
    [
        'title' => 'מעבדה',
        'text' => ['יש לנו מעבדה מתקדמת ומשוכללת המאפשרת לנו לעשות בדיקות דם מלאות, בדיקות שתן משטחי ציטולוגיה ולקבל תשובות מהירות במקום.'],
        'images' => ['66a3bee52ac56e2b512315b2_Alina_on_the_labratorie.jpg', '66a3c8065aed52929d407b23_Offer_labratory.jpg', '66801c4f0a13aa4ac8ddcbf8_DSC08030-min.JPG'],
    ],
    [
        'title' => 'מספרת כלבים',
        'text' => ['מספרת הכלבים המצויינת שלנו בניהולו של שגיא, ספר מנוסה בעל סבלנות ואהבה אין סופית למטופלים שלו, הכל כדי לתת את השירות הטוב ביותר'],
        'images' => ['6680205d4b915ad8e1bb46be_DSC07953-min.JPG', '65bb8d286492feee67c995dc_WhatsApp_Image_2023-12-19_at_11.34.13.jpeg', '66a3bf019015820b3dbdc3ce_grooming_pomerenian.jpeg'],
    ],
];
?>
<section class="page-hero page-hero--clinic">
    <img class="page-hero__bg" src="<?php echo esc_url(ahavat_img('hero_clinic')); ?>" alt="חתול במרפאה" />
    <div class="page-hero__card">
        <h1 class="heading-split"><strong class="heading-split__pink">המרפאה</strong> <span class="heading-split__dark">שלנו</span></h1>
        <p>אנו גאים להיות מובילי דרך בכל הקשור לחדשנות ומצויינות רפואית. המעבדה, הרנטגן, האולטרסאונד ושאר המכשור הרפואי הוא מהחדשים והמתקדמים בעולם.</p>
        <?php ahavat_btn('tel:' . AHAVAT_PHONE_TEL, 'הזמן תור', 'pink'); ?>
    </div>
</section>
<?php foreach ($rooms as $i => $room) : ?>
    <section class="clinic-room <?php echo $i % 2 ? 'clinic-room--flip' : ''; ?>">
        <div class="clinic-room__text">
            <h2 class="text-pink"><?php echo esc_html($room['title']); ?></h2>
            <?php foreach ($room['text'] as $p) : ?>
                <p><?php echo esc_html($p); ?></p>
            <?php endforeach; ?>
        </div>
        <div class="clinic-room__slider slider" data-slider>
            <div class="slider__track">
                <?php foreach ($room['images'] as $n => $img) : ?>
                    <div class="slider__slide <?php echo $n === 0 ? 'is-active' : ''; ?>" style="background-image:url('<?php echo esc_url(ahavat_img($img)); ?>')"></div>
                <?php endforeach; ?>
            </div>
            <div class="slider__dots"></div>
        </div>
    </section>
<?php endforeach; ?>
<?php
get_footer();
