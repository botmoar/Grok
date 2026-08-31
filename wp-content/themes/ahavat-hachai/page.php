<?php
get_header();
while (have_posts()) :
    the_post();
    ?>
    <article class="page-plain">
        <h1><?php the_title(); ?></h1>
        <div class="prose"><?php the_content(); ?></div>
    </article>
    <?php
endwhile;
get_footer();
