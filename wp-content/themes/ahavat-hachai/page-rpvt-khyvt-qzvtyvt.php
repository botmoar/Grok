<?php
/**
 * Template Name: רפואת חיות אקזוטיות
 */
get_header();
?>
<section class="page-hero page-hero--exotic">
    <img class="page-hero__bg" src="<?php echo esc_url(ahavat_img('exotic_hero')); ?>" alt="רפואת חיות אקזוטיות" />
    <div class="page-hero__card">
        <h1 class="heading-split"><strong class="heading-split__pink">רפואת</strong> <span class="heading-split__dark">חיות אקזוטיות</span></h1>
        <p>ארנבים, מכרסמים, תוכים חמוסים וזוחלים, כל חיה תקבל מד״ר אסתי זיו את הטיפול המותאם לה</p>
        <ul class="exotic-points">
            <li>בדיקה שנתית כללית</li>
            <li>יעוץ תזונה וסביבה</li>
            <li>טיפול מותאם וייחודי</li>
            <li>בדיקות דם ומעבדה</li>
        </ul>
        <?php ahavat_btn('tel:' . AHAVAT_PHONE_TEL, 'הזמן תור', 'pink'); ?>
    </div>
</section>
<section class="exotic-blocks">
    <article class="exotic-block">
        <div class="exotic-block__img" style="background-image:url('<?php echo esc_url(ahavat_img('exotic_bunny')); ?>')"></div>
        <div>
            <h2>ארנבים</h2>
            <p>ארנבים הם חיות שנוטות להסתיר מחלות. כל שינוי בהתנהגות : פחות פעילות, ישיבת "כדור", שינויים בדפוסי אכילה שינוים בשתן/בגללים - עלול להיות סימן לבעיה.</p>
        </div>
    </article>
    <article class="exotic-block">
        <div class="exotic-block__img" style="background-image:url('<?php echo esc_url(ahavat_img('exotic_parrot')); ?>')"></div>
        <div>
            <h2>תוכים וציפורים</h2>
            <p>תוכים הם אלופים בהסתרת מחלות, לכן מומלץ להגיע לבדיקה שנתית גם אם הכל נראה כרגיל, כל שינוי קטן, אפילו בצואה יכול להיות סימן ראשון למחלה.</p>
        </div>
    </article>
    <article class="exotic-block">
        <div class="exotic-block__img" style="background-image:url('<?php echo esc_url(ahavat_img('exotic_lizard')); ?>')"></div>
        <div>
            <h2>זוחלים</h2>
            <p>זוחלים דורשים טיפול שמבין אותם, טמפרטורה, תזונה וסביבה.</p>
        </div>
    </article>
</section>
<?php
get_footer();
