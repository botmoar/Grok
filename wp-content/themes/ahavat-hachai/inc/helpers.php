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

function ahavat_images_dir() {
    return get_template_directory() . '/assets/images';
}

/**
 * Map a short name (tick.svg, orly_photo) or hashed Webflow filename to a file
 * that actually exists in assets/images.
 */
function ahavat_resolve_image_file($alias_or_file) {
    static $cache = [];
    $key = (string) $alias_or_file;
    if ($key === '') {
        return '';
    }
    if (array_key_exists($key, $cache)) {
        return $cache[$key];
    }

    $dir = ahavat_images_dir();
    $map = ahavat_aliases();
    $candidates = [];
    if (!empty($map[$key])) {
        $candidates[] = $map[$key];
    }
    $candidates[] = $key;
    $candidates[] = basename(str_replace('\\', '/', $key));

    $unique = [];
    foreach ($candidates as $name) {
        $name = ltrim(str_replace('\\', '/', (string) $name), '/');
        if ($name !== '') {
            $unique[$name] = true;
        }
    }

    foreach (array_keys($unique) as $name) {
        if (is_file($dir . '/' . $name)) {
            return $cache[$key] = $name;
        }
    }

    foreach (array_keys($unique) as $name) {
        $base = basename($name);
        $underscored = str_replace([' ', '%20'], '_', $base);
        $patterns = [
            $dir . '/*_' . $base,
            $dir . '/*' . $base,
            $dir . '/*_' . $underscored,
            $dir . '/*' . $underscored,
        ];
        foreach ($patterns as $pattern) {
            $matches = glob($pattern) ?: [];
            if ($matches) {
                usort($matches, static function ($a, $b) {
                    return strlen($a) <=> strlen($b);
                });
                return $cache[$key] = basename($matches[0]);
            }
        }
    }

    $fallback = !empty($map[$key]) ? $map[$key] : $key;
    return $cache[$key] = ltrim((string) $fallback, '/');
}

function ahavat_img($alias_or_file) {
    $file = ahavat_resolve_image_file($alias_or_file);
    if (!$file || !is_file(ahavat_images_dir() . '/' . $file)) {
        return '';
    }
    $encoded = implode('/', array_map('rawurlencode', explode('/', $file)));
    return rtrim(get_theme_file_uri('assets/images'), '/') . '/' . $encoded;
}

function ahavat_img_path($alias_or_file) {
    $file = ahavat_resolve_image_file($alias_or_file);
    return ahavat_images_dir() . '/' . ltrim((string) $file, '/');
}

function ahavat_team_photo_fallbacks() {
    return [
        'sagi-yarkoni' => 'sagi_yarkoni.jpg',
        'ron-ponti' => 'ron_ponti.jpg',
        'reut-avraham' => 'reut_avraham.jpeg',
    ];
}

function ahavat_team_photo_url($post_id) {
    $url = get_the_post_thumbnail_url($post_id, 'large');
    if ($url) {
        return $url;
    }
    $file = get_post_meta($post_id, '_ahavat_photo', true);
    $from_file = $file ? ahavat_img($file) : '';
    if ($from_file) {
        return $from_file;
    }
    $slug = get_post_field('post_name', $post_id);
    $fallbacks = ahavat_team_photo_fallbacks();
    $file = $fallbacks[$slug] ?? '';
    return $file ? ahavat_img($file) : '';
}

function ahavat_team_avatar_url($post_id) {
    $avatar = get_post_meta($post_id, '_ahavat_avatar', true);
    if (!$avatar) {
        return '';
    }
    if (strpos($avatar, 'http://') === 0 || strpos($avatar, 'https://') === 0) {
        return $avatar;
    }
    return ahavat_img($avatar);
}

function ahavat_faq_category_order() {
    return [
        'פרעושים וקרציות',
        'שיניים וחניכיים',
        'השמנה ובעיות משקל',
        'תזונה',
        'כלבים כללי',
        'חתולים כללי',
    ];
}

function ahavat_faq_terms() {
    $terms = get_terms([
        'taxonomy' => 'faq_category',
        'hide_empty' => false,
    ]);
    if (is_wp_error($terms) || !$terms) {
        return [];
    }
    $rank = array_flip(ahavat_faq_category_order());
    usort($terms, static function ($a, $b) use ($rank) {
        $oa = $rank[$a->name] ?? 999;
        $ob = $rank[$b->name] ?? 999;
        if ($oa === $ob) {
            $ma = (int) get_term_meta($a->term_id, '_ahavat_order', true);
            $mb = (int) get_term_meta($b->term_id, '_ahavat_order', true);
            if ($ma !== $mb) {
                return $ma <=> $mb;
            }
            return strcasecmp($a->name, $b->name);
        }
        return $oa <=> $ob;
    });
    return $terms;
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
