<?php
/**
 * Template Name: חיפוש
 */
get_header();
$q = get_search_query() ?: sanitize_text_field(wp_unslash($_GET['query'] ?? $_GET['s'] ?? ''));
?>
<section class="search-page">
    <h1>חיפוש</h1>
    <form class="search-form" action="<?php echo esc_url(home_url('/search/')); ?>" method="get">
        <label class="visually-hidden" for="site-search">חפש שאלה...</label>
        <input id="site-search" type="search" name="s" value="<?php echo esc_attr($q); ?>" placeholder="חפש שאלה..." />
        <button class="btn btn--pink" type="submit">חפש</button>
    </form>
    <?php if ($q !== '') : ?>
        <?php
        $results = new WP_Query([
            's' => $q,
            'post_type' => ['post', 'page', 'faq_item', 'team_member'],
            'posts_per_page' => 20,
        ]);
        if ($results->have_posts()) :
            echo '<ul class="search-results">';
            while ($results->have_posts()) :
                $results->the_post();
                echo '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        else :
            echo '<p>לא נמצאו תוצאות תואמות.</p>';
        endif;
        ?>
    <?php else : ?>
        <p>הקלידו מילת חיפוש.</p>
    <?php endif; ?>
</section>
<?php
get_footer();
