<?php
/**
 * Template Name: הצוות
 */
get_header();
?>
<section class="page-hero page-hero--team">
    <img class="page-hero__bg" src="<?php echo esc_url(ahavat_img('hero_team')); ?>" alt="הצוות שלנו" />
    <div class="page-hero__card">
        <h1 class="heading-split"><strong class="heading-split__pink">הצוות</strong> <span class="heading-split__dark">שלנו</span></h1>
        <p>אנחנו ממש אוהבים את מה שאנחנו עושים.<br />אוהבים בעלי חיים, אוהבים אנשים ואוהבים לעבוד ביחד.</p>
    </div>
    <div class="page-hero__cta">
        <?php ahavat_btn('tel:' . AHAVAT_PHONE_TEL, 'הזמן תור למרפאה', 'pink'); ?>
    </div>
</section>
<section class="team-page">
    <div class="team-grid">
        <?php
        $team = ahavat_team_members(false);
        if ($team->have_posts()) :
            while ($team->have_posts()) :
                $team->the_post();
                get_template_part('template-parts/team', 'card');
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>
<?php
get_footer();
