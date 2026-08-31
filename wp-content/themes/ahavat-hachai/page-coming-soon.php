<?php
/**
 * Template Name: בקרוב
 */
get_header();
$slug = get_post_field('post_name', get_the_ID());
$is_dental = $slug === 'dental-treatment';
$heading = $is_dental ? 'דף טיפולי שיניים בדרך אליכם....' : 'דף רפואה אלטרנטיבית בדרך אליכם....';
$img = $is_dental ? ahavat_img('coming_dental') : ahavat_img('coming_alt');
?>
<section class="coming-soon">
    <h1><?php echo esc_html($heading); ?></h1>
    <p>אנחנו עובדים על תוכן חדש שיעזור לכם לטפל בחיות המחמד שלכם בצורה הטובה ביותר....</p>
    <?php if ($img) : ?>
        <img src="<?php echo esc_url($img); ?>" alt="" loading="lazy" />
    <?php endif; ?>
    <div class="btn-row">
        <?php ahavat_btn('tel:' . AHAVAT_PHONE_TEL, 'דברו איתנו', 'pink'); ?>
        <?php ahavat_btn(ahavat_whatsapp_url(), 'כתבו לנו', 'outline'); ?>
    </div>
</section>
<?php
get_footer();
