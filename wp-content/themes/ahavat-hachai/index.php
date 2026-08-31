<?php
get_header();
?>
<section class="articles-page">
    <header class="section-head">
        <h1 class="heading-split"><strong class="heading-split__pink">מאמרים</strong></h1>
    </header>
    <div class="article-list">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <a class="article-row" href="<?php the_permalink(); ?>">
                <h2><?php the_title(); ?></h2>
            </a>
        <?php endwhile; endif; ?>
    </div>
</section>
<?php
get_footer();
