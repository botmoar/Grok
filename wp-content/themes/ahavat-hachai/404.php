<?php
get_header();
?>
<section class="error-404">
    <h1>אופס, העמוד לא נמצא</h1>
    <p>נראה שהגעתם לעמוד שלא קיים באתר אהבת החי. אולי חזרתם אחורה, או שהקישור השתנה.</p>
    <img src="<?php echo esc_url(ahavat_img('logo')); ?>" alt="אהבת החי" width="220" />
    <div class="btn-row">
        <?php ahavat_btn(home_url('/'), 'חזרה לדף הבית', 'pink'); ?>
        <?php ahavat_btn('tel:' . AHAVAT_PHONE_TEL, 'דברו איתנו', 'outline'); ?>
    </div>
</section>
<?php
get_footer();
