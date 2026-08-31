<?php
/**
 * Per-page SEO titles, Open Graph, and LocalBusiness JSON-LD.
 */

if (!defined('ABSPATH')) {
    exit;
}

function ahavat_seo_meta($post_id = 0) {
    $post_id = $post_id ?: get_queried_object_id();
    $defaults = [
        'title' => '',
        'description' => '',
        'og_image' => ahavat_img('hero_home'),
    ];
    if (!$post_id) {
        if (is_front_page()) {
            return [
                'title' => 'מרפאה וטרינרית בתל אביב - כלבים, חתולים, זוחלים וחיות אקזוטיות | אהבת החי',
                'description' => 'מרפאה וטרינרית מקצועית בצפון ת״א ⭐ טיפול בכלבים, חתולים, ארנבים, אוגרים וציפורים | ציוד מתקדם ושירות אישי | ד״ר עופר שביט - הדר יוסף',
                'og_image' => ahavat_img('hero_home'),
            ];
        }
        if (is_search()) {
            return [
                'title' => 'חיפוש | אהבת החי',
                'description' => 'חיפוש באתר אהבת החי',
                'og_image' => ahavat_img('hero_home'),
            ];
        }
        if (is_404()) {
            return [
                'title' => 'העמוד לא נמצא | אהבת החי',
                'description' => 'העמוד שחיפשתם לא נמצא באתר אהבת החי.',
                'og_image' => ahavat_img('hero_home'),
            ];
        }
        return $defaults;
    }
    $title = get_post_meta($post_id, '_ahavat_seo_title', true);
    $desc = get_post_meta($post_id, '_ahavat_seo_description', true);
    $og = get_post_meta($post_id, '_ahavat_og_image', true);
    if (!$title) {
        $title = get_the_title($post_id) . ' | אהבת החי';
    }
    if (!$desc) {
        $desc = wp_strip_all_tags(get_post_field('post_excerpt', $post_id) ?: get_post_field('post_content', $post_id));
        $desc = mb_substr($desc, 0, 160);
    }
    if (!$og) {
        $thumb = get_the_post_thumbnail_url($post_id, 'full');
        $og = $thumb ?: ahavat_img('hero_home');
    } elseif (strpos($og, 'http') !== 0) {
        $og = ahavat_img($og) ?: get_theme_file_uri('assets/images/' . $og);
    }
    return [
        'title' => $title,
        'description' => $desc,
        'og_image' => $og,
    ];
}

add_filter('pre_get_document_title', function ($title) {
    $seo = ahavat_seo_meta();
    return $seo['title'] ?: $title;
});

add_filter('document_title_parts', function ($parts) {
    $seo = ahavat_seo_meta();
    if (!empty($seo['title'])) {
        return ['title' => $seo['title']];
    }
    return $parts;
});

add_action('wp_head', function () {
    $seo = ahavat_seo_meta();
    $url = (is_singular() || is_front_page()) ? get_permalink() : home_url(add_query_arg([]));
    if (is_front_page()) {
        $url = home_url('/');
    }
    echo '<meta name="description" content="' . esc_attr($seo['description']) . "\" />\n";
    echo '<meta property="og:locale" content="he_IL" />' . "\n";
    echo '<meta property="og:type" content="' . (is_singular('post') ? 'article' : 'website') . "\" />\n";
    echo '<meta property="og:title" content="' . esc_attr($seo['title']) . "\" />\n";
    echo '<meta property="og:description" content="' . esc_attr($seo['description']) . "\" />\n";
    echo '<meta property="og:url" content="' . esc_url($url) . "\" />\n";
    echo '<meta property="og:site_name" content="אהבת החי" />' . "\n";
    echo '<meta property="og:image" content="' . esc_url($seo['og_image']) . "\" />\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($seo['title']) . "\" />\n";
    echo '<meta name="twitter:description" content="' . esc_attr($seo['description']) . "\" />\n";
    echo '<meta name="twitter:image" content="' . esc_url($seo['og_image']) . "\" />\n";
    echo '<link rel="canonical" href="' . esc_url($url) . "\" />\n";
}, 2);

add_action('wp_head', function () {
    $data = [
        '@context' => 'https://schema.org',
        '@type' => ['VeterinaryCare', 'LocalBusiness'],
        'name' => 'אהבת החי',
        'alternateName' => 'Ahavat HaChai',
        'description' => 'מרכז וטרינרי בצפון תל אביב בניהולו של ד״ר עופר שביט.',
        'url' => home_url('/'),
        'image' => ahavat_img('hero_home'),
        'logo' => ahavat_img('logo'),
        'telephone' => AHAVAT_PHONE_TEL,
        'email' => AHAVAT_EMAIL_VET,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'יד המעביר 9',
            'addressLocality' => 'תל אביב',
            'addressRegion' => 'הדר יוסף',
            'addressCountry' => 'IL',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => AHAVAT_LAT,
            'longitude' => AHAVAT_LNG,
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'],
                'opens' => '08:30',
                'closes' => '19:00',
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'Friday',
                'opens' => '08:30',
                'closes' => '13:30',
            ],
        ],
        'sameAs' => [AHAVAT_FB, AHAVAT_IG],
        'priceRange' => '$$',
        'founder' => [
            '@type' => 'Person',
            'name' => 'ד״ר עופר שביט',
        ],
    ];
    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}, 20);

add_action('add_meta_boxes', function () {
    add_meta_box('ahavat_seo', 'SEO', function ($post) {
        wp_nonce_field('ahavat_seo', 'ahavat_seo_nonce');
        $title = get_post_meta($post->ID, '_ahavat_seo_title', true);
        $desc = get_post_meta($post->ID, '_ahavat_seo_description', true);
        echo '<p><label>כותרת SEO<br><input type="text" name="ahavat_seo_title" value="' . esc_attr($title) . '" class="widefat" /></label></p>';
        echo '<p><label>תיאור מטא<br><textarea name="ahavat_seo_description" class="widefat" rows="3">' . esc_textarea($desc) . '</textarea></label></p>';
    }, ['page', 'post', 'team_member'], 'normal');
});

add_action('save_post', function ($post_id) {
    if (!isset($_POST['ahavat_seo_nonce']) || !wp_verify_nonce($_POST['ahavat_seo_nonce'], 'ahavat_seo')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['ahavat_seo_title'])) {
        update_post_meta($post_id, '_ahavat_seo_title', sanitize_text_field(wp_unslash($_POST['ahavat_seo_title'])));
    }
    if (isset($_POST['ahavat_seo_description'])) {
        update_post_meta($post_id, '_ahavat_seo_description', sanitize_textarea_field(wp_unslash($_POST['ahavat_seo_description'])));
    }
});
