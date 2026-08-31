<?php
/**
 * Template Name: המספרה
 */
get_header();
$gallery = [
    '66a3cd2d976543d4cef4ab68_grooming_white_dog.jpeg',
    '66a3bf018dfc703c7cd94ff2_grooming_poodel_2.jpeg',
    '66a3bee547ef5bdfc7458d4c_Sagi_the_groomer_2.jpg',
    '66a3bf01362ddb8326a328b0_grooming_white_poodel.jpeg',
    '66a3bf02672cf61e00c2b033_grooming-min_54_11zon.jpg',
    '66a3bf018036c99125b37469_grooming_3.jpeg',
    '668025e14890c43da84a9751_WhatsApp_Image_2024-01-23_at_15.37.57-min.png',
    '6680205d87dbb7496cb8b713_DSC08073-min.JPG',
    '668029d38d028dda559676ba_WhatsApp_Image_2024-01-23_at_15.37.57_-1--min.png',
];
?>
<section class="page-hero page-hero--grooming">
    <img class="page-hero__bg" src="<?php echo esc_url(ahavat_img('hero_grooming')); ?>" alt="פומרניאן במספרה" />
    <div class="page-hero__card">
        <h1 class="heading-split"><strong class="heading-split__pink">המספרה</strong> <span class="heading-split__dark">שלנו</span></h1>
        <p>יש לנו מספרת כלבים מקצועית שעושה תספורות, תספורות גזע וטיפוחים.</p>
        <p>שגיא הספר שלנו עובד באהבה גדולה תוך תשומת לב לפרטים הקטנים, שימוש בחומרים המשובחים ביותר וסבלנות אין קץ למסופרים.</p>
        <?php ahavat_btn('tel:' . AHAVAT_PHONE_TEL, 'הזמן תור למספרה', 'pink'); ?>
    </div>
</section>
<section class="gallery-grid">
    <?php foreach ($gallery as $img) :
        $src = ahavat_img($img);
        if (!$src) {
            continue;
        }
        ?>
        <img src="<?php echo esc_url($src); ?>" alt="המספרה של אהבת החי" loading="lazy" />
    <?php endforeach; ?>
</section>
<?php
get_footer();
