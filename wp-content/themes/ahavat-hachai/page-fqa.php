<?php
/**
 * Template Name: שאלות ותשובות
 */
get_header();
$terms = get_terms(['taxonomy' => 'faq_category', 'hide_empty' => false]);
?>
<section class="faq-page">
    <header class="section-head">
        <h1 class="heading-split"><strong class="heading-split__pink">שאלות</strong> <span class="heading-split__dark">ותשובות</span></h1>
        <p>ריכזנו בשבילכם מספר שאלות ותשובות שאנחנו נתקלים בהן הרבה במרפאה. יש לכם שאלות נוספות? מוזמנים לכתוב לנו בוואטאפ או להתקשר, נשמח לענות!</p>
        <form class="search-form search-form--faq" action="<?php echo esc_url(home_url('/search/')); ?>" method="get">
            <label class="visually-hidden" for="faq-search">חפש שאלה</label>
            <input id="faq-search" type="search" name="s" placeholder="חפש שאלה..." />
            <button class="btn btn--pink" type="submit">חפש</button>
        </form>
    </header>
    <?php
    if ($terms && !is_wp_error($terms)) :
        foreach ($terms as $term) :
            $items = new WP_Query([
                'post_type' => 'faq_item',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'tax_query' => [[
                    'taxonomy' => 'faq_category',
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                ]],
            ]);
            if (!$items->have_posts()) {
                continue;
            }
            ?>
            <section class="faq-group">
                <h2><?php echo esc_html($term->name); ?></h2>
                <?php
                while ($items->have_posts()) :
                    $items->the_post();
                    $icon = get_post_meta(get_the_ID(), '_ahavat_icon', true);
                    $icon_url = $icon ? get_theme_file_uri('assets/images/' . $icon) : '';
                    ?>
                    <details class="faq-item">
                        <summary>
                            <?php if ($icon_url) : ?>
                                <img src="<?php echo esc_url($icon_url); ?>" alt="" width="28" height="28" />
                            <?php endif; ?>
                            <span><?php the_title(); ?></span>
                        </summary>
                        <div class="faq-item__body">
                            <?php echo apply_filters('the_content', get_the_content()); ?>
                        </div>
                    </details>
                <?php endwhile; wp_reset_postdata(); ?>
            </section>
        <?php
        endforeach;
    endif;
    ?>
</section>
<?php
get_footer();
