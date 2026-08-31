<?php
get_header();
while (have_posts()) :
    the_post();
    $author = get_post_meta(get_the_ID(), '_ahavat_author', true);
    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
    ?>
    <article class="article-single">
        <header class="article-single__head">
            <p class="crumb"><a href="<?php echo esc_url(home_url('/mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym/')); ?>">מאמרים</a></p>
            <h1><?php the_title(); ?></h1>
            <?php if ($author) : ?><p class="article-single__author"><?php echo esc_html($author); ?></p><?php endif; ?>
        </header>
        <?php if ($thumb) : ?>
            <img class="article-single__hero" src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" />
        <?php endif; ?>
        <div class="prose">
            <?php echo apply_filters('the_content', ahavat_replace_theme_img_placeholder(get_the_content())); ?>
        </div>
        <p class="article-single__back"><a href="<?php echo esc_url(home_url('/mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym/')); ?>">חזרה לכל המאמרים</a></p>
    </article>
    <?php
endwhile;
get_footer();
