<?php
get_header();
$q = get_search_query();
?>
<section class="search-page">
    <h1>תוצאות חיפוש</h1>
    <form class="search-form" action="<?php echo esc_url(home_url('/search/')); ?>" method="get">
        <label class="visually-hidden" for="site-search">חפש שאלה...</label>
        <input id="site-search" type="search" name="s" value="<?php echo esc_attr($q); ?>" placeholder="חפש שאלה..." />
        <button class="btn btn--pink" type="submit">חפש</button>
    </form>
    <?php if (have_posts()) : ?>
        <ul class="search-results">
            <?php while (have_posts()) : the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>לא נמצאו תוצאות תואמות.</p>
    <?php endif; ?>
</section>
<?php
get_footer();
