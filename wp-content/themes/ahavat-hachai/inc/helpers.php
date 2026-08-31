<?php
/**
 * Theme helpers.
 */

if (!defined('ABSPATH')) {
    exit;
}

function ahavat_aliases() {
    static $map;
    if ($map === null) {
        $map = include get_template_directory() . '/inc/image-aliases.php';
    }
    return $map;
}

function ahavat_img($alias_or_file) {
    $map = ahavat_aliases();
    $file = $map[$alias_or_file] ?? $alias_or_file;
    if (!$file) {
        return '';
    }
    return get_theme_file_uri('assets/images/' . ltrim($file, '/'));
}

function ahavat_img_path($alias_or_file) {
    $map = ahavat_aliases();
    $file = $map[$alias_or_file] ?? $alias_or_file;
    return get_template_directory() . '/assets/images/' . ltrim($file, '/');
}

function ahavat_whatsapp_url($text = AHAVAT_WHATSAPP_TEXT) {
    return 'https://wa.me/' . AHAVAT_WHATSAPP_E164 . '?text=' . rawurlencode($text);
}

function ahavat_gtm_id() {
    $id = get_theme_mod('ahavat_gtm_id', defined('AHAVAT_GTM_ID') ? AHAVAT_GTM_ID : '');
    return preg_match('/^GTM-[A-Z0-9]+$/', $id) ? $id : '';
}

function ahavat_is_current($path) {
    if ($path === '/' || $path === '') {
        return is_front_page();
    }
    $req = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    return $req === trim($path, '/');
}

function ahavat_nav_class($path) {
    return ahavat_is_current($path) ? 'site-nav__link is-active' : 'site-nav__link';
}

function ahavat_two_tone($first, $second, $tag = 'h1', $class = 'heading-split', $flip = false) {
    $a = esc_html($first);
    $b = esc_html($second);
    if ($flip) {
        printf('<%1$s class="%2$s"><span class="heading-split__dark">%3$s</span> <strong class="heading-split__pink">%4$s</strong></%1$s>', $tag, esc_attr($class), $a, $b);
    } else {
        printf('<%1$s class="%2$s"><strong class="heading-split__pink">%3$s</strong> <span class="heading-split__dark">%4$s</span></%1$s>', $tag, esc_attr($class), $a, $b);
    }
}

function ahavat_btn($href, $label, $variant = 'pink', $extra = '') {
    $class = 'btn btn--' . $variant . ($extra ? ' ' . $extra : '');
    printf(
        '<a class="%s" href="%s">%s</a>',
        esc_attr($class),
        esc_url($href),
        esc_html($label)
    );
}

function ahavat_btn_icon($href, $label, $icon_alias, $variant = 'pink', $attrs = '') {
    printf(
        '<a class="btn btn--%s btn--icon" href="%s" %s><img src="%s" alt="" width="18" height="18" /><span>%s</span></a>',
        esc_attr($variant),
        esc_url($href),
        $attrs,
        esc_url(ahavat_img($icon_alias)),
        esc_html($label)
    );
}

function ahavat_team_members($featured_only = false) {
    $args = [
        'post_type' => 'team_member',
        'posts_per_page' => $featured_only ? 4 : -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'no_found_rows' => true,
    ];
    if ($featured_only) {
        $args['meta_key'] = '_ahavat_featured';
        $args['meta_value'] = '1';
    }
    return new WP_Query($args);
}

function ahavat_replace_theme_img_placeholder($html) {
    $base = get_theme_file_uri('assets/images');
    return str_replace('{{theme_img}}', esc_url($base), $html);
}

function ahavat_lazy_img($src, $alt = '', $class = '', $width = null, $height = null) {
    if (!$src) {
        return;
    }
    $w = $width ? ' width="' . intval($width) . '"' : '';
    $h = $height ? ' height="' . intval($height) . '"' : '';
    printf(
        '<img src="%s" alt="%s" class="%s" loading="lazy" decoding="async"%s%s />',
        esc_url($src),
        esc_attr($alt),
        esc_attr($class),
        $w,
        $h
    );
}

function ahavat_page_id_by_slug($slug) {
    $page = get_page_by_path($slug);
    return $page ? (int) $page->ID : 0;
}
