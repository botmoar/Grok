<?php
/**
 * Template Name: מאמרים
 */
get_header();
$posts = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
]);
?>
<section class="articles-page">
    <header class="section-head">
        <h1 class="heading-split"><strong class="heading-split__pink">מאמרים</strong></h1>
        <p>הוטרינרים המעולים שלנו ואורלי, המטפלת האלטרנטיבית, ריכזו עבורכם מאמרים רפואיים על מגוון נושאים הקשורים בחיית המחמד שלכם.</p>
    </header>
    <div class="article-list">
        <?php if ($posts->have_posts()) : while ($posts->have_posts()) : $posts->the_post();
            $author = get_post_meta(get_the_ID(), '_ahavat_author', true);
            ?>
            <a class="article-row" href="<?php the_permalink(); ?>">
                <div>
                    <h2><?php the_title(); ?></h2>
                    <?php if ($author) : ?><p class="article-row__author"><?php echo esc_html($author); ?></p><?php endif; ?>
                </div>
                <span class="article-row__chevron" aria-hidden="true"></span>
            </a>
        <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
</section>
<?php
get_footer();
