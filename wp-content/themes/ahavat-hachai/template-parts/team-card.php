<?php
$role = get_post_meta(get_the_ID(), '_ahavat_role', true);
$role_short = get_post_meta(get_the_ID(), '_ahavat_role_short', true) ?: $role;
$photo = get_the_post_thumbnail_url(get_the_ID(), 'large');
$avatar = get_post_meta(get_the_ID(), '_ahavat_avatar', true);
if ($avatar && strpos($avatar, 'http') !== 0) {
    $avatar = get_theme_file_uri('assets/images/' . $avatar);
}
?>
<article class="team-card" data-flip>
    <div class="team-card__inner">
        <div class="team-card__front">
            <?php if ($photo) : ?>
                <img src="<?php echo esc_url($photo); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
            <?php endif; ?>
            <div class="team-card__caption">
                <?php if ($rotate = ahavat_img('icon_rotate')) : ?>
                    <img class="team-card__flip-icon" src="<?php echo esc_url($rotate); ?>" alt="" />
                <?php endif; ?>
                <h3><?php the_title(); ?></h3>
                <p><?php echo esc_html($role_short); ?></p>
            </div>
        </div>
        <div class="team-card__back">
            <?php if ($avatar) : ?>
                <img class="team-card__avatar" src="<?php echo esc_url($avatar); ?>" alt="<?php the_title_attribute(); ?>" />
            <?php endif; ?>
            <h3><?php the_title(); ?></h3>
            <div class="team-card__bio"><?php the_content(); ?></div>
        </div>
    </div>
</article>
