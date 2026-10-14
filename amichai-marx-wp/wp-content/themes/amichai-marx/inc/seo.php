<?php
/**
 * Titles, meta description, Open Graph, canonical.
 */

defined('ABSPATH') || exit;

function amichai_seo_title_raw(): string {
    if (is_front_page()) {
        return 'ייעוץ לכלכלת המשפחה וביטחון פיננסי | עמיחי מרקס';
    }
    if (is_singular()) {
        $custom = get_post_meta(get_queried_object_id(), '_amichai_seo_title', true);
        if (is_string($custom) && $custom !== '') {
            return $custom;
        }
        return wp_strip_all_tags(get_the_title()) . ' | עמיחי מרקס';
    }
    if (is_category()) {
        return single_cat_title('', false) . ' | עמיחי מרקס';
    }
    if (is_search()) {
        return 'חיפוש: ' . get_search_query() . ' | עמיחי מרקס';
    }
    if (is_404()) {
        return 'העמוד לא נמצא | עמיחי מרקס';
    }
    return 'עמיחי מרקס | ייעוץ לכלכלת המשפחה';
}

add_filter('pre_get_document_title', static function (): string {
    return amichai_seo_title_raw() . amichai_page_suffix();
});

remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('template_redirect', 'wp_shortlink_header', 11);

function amichai_page_suffix(): string {
    $paged = (int) get_query_var('paged');
    return $paged > 1 ? ' | עמוד ' . $paged : '';
}

function amichai_meta_description(): string {
    if (is_singular()) {
        $custom = get_post_meta(get_queried_object_id(), '_amichai_meta_desc', true);
        if (is_string($custom) && $custom !== '') {
            return $custom;
        }
        $excerpt = get_the_excerpt();
        if ($excerpt) {
            return wp_strip_all_tags($excerpt);
        }
    }
    if (is_front_page()) {
        return 'ייעוץ לכלכלת המשפחה ומשכנתאות בליווי צמוד: תקציב, מינוס, משכנתא, חסכונות והשקעות. עמיחי מרקס, 15 שנה בליווי משפחות. 054-2372417.';
    }
    if (is_category()) {
        $by_cat = [
            'מאמרים' => 'מאמרים על תקציב, יציאה מהמינוס, משכנתאות, חסכונות וזכויות. עמיחי מרקס, יועץ לכלכלת המשפחה ויועץ משכנתאות.',
            'סיפורי משפחות' => 'סיפורים, המלצות ומכתבי תודה ממשפחות שליווה עמיחי מרקס בתקציב, במשכנתא ובחסכונות.',
            'ייעוץ כלכלי' => 'מאמרים על ייעוץ כלכלי למשפחות: איך נראה התהליך, למי הוא מתאים ומה מקבלים ממנו.',
            'משכנתאות' => 'ייעוץ משכנתאות לפי המצב שלכם: רכישה ראשונה, מחזור, שיפוץ, מסורבים ומשכנתא הפוכה.',
            'שירותים שלנו' => 'הרצאות, סדנאות וליווי אישי בכלכלת המשפחה עם עמיחי מרקס.',
        ];
        $name = single_cat_title('', false);
        $desc = trim(wp_strip_all_tags(category_description()));
        $desc = $desc !== '' ? $desc : ($by_cat[$name] ?? $name . ': מאמרים מאת עמיחי מרקס, יועץ לכלכלת המשפחה.');
        $paged = (int) get_query_var('paged');
        return $paged > 1 ? $desc . ' עמוד ' . $paged . '.' : $desc;
    }
    return 'עמיחי מרקס, ייעוץ לכלכלת המשפחה וביטחון פיננסי. טלפון 054-2372417.';
}

add_action('wp_head', function (): void {
    $desc = amichai_meta_description();
    $title = amichai_seo_title_raw() . amichai_page_suffix();
    $url = amichai_current_url();
    $image = get_template_directory_uri() . '/assets/images/amichai-marx.jpg';
    if (is_singular()) {
        $thumb_id = get_post_thumbnail_id(get_queried_object_id());
        if ($thumb_id) {
            $thumb = wp_get_attachment_image_url($thumb_id, 'large');
            if (is_string($thumb) && $thumb !== '') {
                $image = $thumb;
            }
        }
    }
    echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:locale" content="he_IL">' . "\n";
    echo '<meta property="og:site_name" content="עמיחי מרקס">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:type" content="' . (is_singular('post') ? 'article' : 'website') . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
}, 1);

function amichai_current_url(): string {
    if (is_singular()) {
        return get_permalink();
    }
    if (is_category() || is_tag() || is_search() || is_archive()) {
        $link = get_pagenum_link(max(1, (int) get_query_var('paged')));
        return is_string($link) ? $link : home_url('/');
    }
    return home_url(add_query_arg([]));
}
