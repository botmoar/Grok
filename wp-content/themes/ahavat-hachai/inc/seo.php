<?php
/**
 * Per-page SEO titles, Open Graph, Twitter, robots, canonical, and JSON-LD.
 */

if (!defined('ABSPATH')) {
    exit;
}

function ahavat_seo_default_image() {
    return ahavat_img('hero_home');
}

function ahavat_seo_resolve_image($value) {
    if (!$value) {
        return ahavat_seo_default_image();
    }
    if (strpos($value, 'http://') === 0 || strpos($value, 'https://') === 0) {
        return $value;
    }
    $from_alias = ahavat_img($value);
    if ($from_alias && strpos($from_alias, '/assets/images/') !== false) {
        $path = ahavat_img_path($value);
        if (is_file($path)) {
            return $from_alias;
        }
    }
    $file = ltrim($value, '/');
    $path = get_template_directory() . '/assets/images/' . $file;
    if (is_file($path)) {
        return get_theme_file_uri('assets/images/' . $file);
    }
    return ahavat_seo_default_image();
}

function ahavat_seo_image_meta($url) {
    $width = 1200;
    $height = 630;
    $type = '';
    $path = '';
    $theme_uri = trailingslashit(get_theme_file_uri('assets/images'));
    if (strpos($url, $theme_uri) === 0) {
        $path = get_template_directory() . '/assets/images/' . substr($url, strlen($theme_uri));
    }
    if ($path && is_file($path)) {
        $info = @getimagesize($path);
        if ($info) {
            $width = (int) $info[0];
            $height = (int) $info[1];
            $type = $info['mime'] ?? '';
        }
    }
    return compact('width', 'height', 'type');
}

function ahavat_canonical_url() {
    if (is_404()) {
        return '';
    }
    if (is_front_page()) {
        return home_url('/');
    }
    if (is_search()) {
        return home_url('/search/');
    }
    if (is_singular()) {
        return get_permalink();
    }
    $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    return home_url(user_trailingslashit($path ?: '/'));
}

function ahavat_seo_robots_value($post_id = 0) {
    if (is_search() || is_404()) {
        return 'noindex, follow';
    }
    if ($post_id) {
        $stored = get_post_meta($post_id, '_ahavat_robots', true);
        if ($stored) {
            return $stored;
        }
    }
    return 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
}

function ahavat_seo_meta($post_id = 0) {
    $post_id = $post_id ?: (int) get_queried_object_id();
    $defaults = [
        'title' => get_bloginfo('name'),
        'description' => 'מרכז וטרינרי אהבת החי בצפון תל אביב בניהולו של ד״ר עופר שביט.',
        'og_image' => ahavat_seo_default_image(),
        'og_title' => '',
        'og_description' => '',
        'robots' => ahavat_seo_robots_value($post_id),
    ];

    if (is_search()) {
        return [
            'title' => 'חיפוש | אהבת החי',
            'description' => 'חיפוש באתר אהבת החי — מאמרים, שאלות ותשובות ושירותי המרכז הוטרינרי.',
            'og_image' => ahavat_seo_default_image(),
            'og_title' => 'חיפוש | אהבת החי',
            'og_description' => 'חיפוש באתר אהבת החי — מאמרים, שאלות ותשובות ושירותי המרכז הוטרינרי.',
            'robots' => 'noindex, follow',
        ];
    }
    if (is_404()) {
        return [
            'title' => 'העמוד לא נמצא | אהבת החי',
            'description' => 'העמוד שחיפשתם לא נמצא באתר אהבת החי. חזרו לדף הבית או צרו קשר בטלפון 03-6472933.',
            'og_image' => ahavat_seo_default_image(),
            'og_title' => 'העמוד לא נמצא | אהבת החי',
            'og_description' => 'העמוד שחיפשתם לא נמצא באתר אהבת החי.',
            'robots' => 'noindex, follow',
        ];
    }

    if (!$post_id && is_front_page()) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $post_id = $front_id;
        }
    }

    if (!$post_id) {
        return $defaults;
    }

    $title = (string) get_post_meta($post_id, '_ahavat_seo_title', true);
    $desc = (string) get_post_meta($post_id, '_ahavat_seo_description', true);
    $og_title = (string) get_post_meta($post_id, '_ahavat_og_title', true);
    $og_desc = (string) get_post_meta($post_id, '_ahavat_og_description', true);
    $og = (string) get_post_meta($post_id, '_ahavat_og_image', true);

    if (!$title) {
        $title = get_the_title($post_id) . ' | אהבת החי';
    }
    if (!$desc) {
        $excerpt = get_post_field('post_excerpt', $post_id);
        $raw = $excerpt ?: get_post_field('post_content', $post_id);
        $desc = mb_substr(trim(preg_replace('/\s+/u', ' ', wp_strip_all_tags((string) $raw))), 0, 160);
    }
    if (!$og) {
        $thumb = get_the_post_thumbnail_url($post_id, 'full');
        $og = $thumb ?: ahavat_seo_default_image();
    } else {
        $og = ahavat_seo_resolve_image($og);
    }
    if (!$og_title) {
        $og_title = $title;
    }
    if (!$og_desc) {
        $og_desc = $desc;
    }

    return [
        'title' => $title,
        'description' => $desc,
        'og_image' => $og,
        'og_title' => $og_title,
        'og_description' => $og_desc,
        'robots' => ahavat_seo_robots_value($post_id),
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

add_action('after_setup_theme', function () {
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
}, 20);

add_filter('the_generator', '__return_empty_string');

add_action('wp_head', function () {
    $seo = ahavat_seo_meta();
    $url = ahavat_canonical_url();
    $img = ahavat_seo_image_meta($seo['og_image']);
    $og_type = is_singular('post') ? 'article' : 'website';
    $robots = $seo['robots'];

    echo '<meta name="description" content="' . esc_attr($seo['description']) . "\" />\n";
    echo '<meta name="robots" content="' . esc_attr($robots) . "\" />\n";
    echo '<meta name="googlebot" content="' . esc_attr($robots) . "\" />\n";
    echo '<meta name="theme-color" content="#ED2590" />' . "\n";
    echo '<meta name="geo.region" content="IL-TA" />' . "\n";
    echo '<meta name="geo.placename" content="הדר יוסף, תל אביב" />' . "\n";
    echo '<meta name="geo.position" content="' . esc_attr(AHAVAT_LAT . ';' . AHAVAT_LNG) . "\" />\n";
    echo '<meta name="ICBM" content="' . esc_attr(AHAVAT_LAT . ', ' . AHAVAT_LNG) . "\" />\n";
    echo '<meta name="format-detection" content="telephone=no" />' . "\n";

    $verify = ahavat_google_site_verification();
    if ($verify) {
        echo '<meta name="google-site-verification" content="' . esc_attr($verify) . "\" />\n";
    }

    if ($url) {
        echo '<link rel="canonical" href="' . esc_url($url) . "\" />\n";
        echo '<link rel="alternate" hreflang="he" href="' . esc_url($url) . "\" />\n";
        echo '<link rel="alternate" hreflang="he-IL" href="' . esc_url($url) . "\" />\n";
        echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($url) . "\" />\n";
    }

    echo '<meta property="og:locale" content="he_IL" />' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . "\" />\n";
    echo '<meta property="og:site_name" content="אהבת החי" />' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($seo['og_title']) . "\" />\n";
    echo '<meta property="og:description" content="' . esc_attr($seo['og_description']) . "\" />\n";
    if ($url) {
        echo '<meta property="og:url" content="' . esc_url($url) . "\" />\n";
    }
    echo '<meta property="og:image" content="' . esc_url($seo['og_image']) . "\" />\n";
    echo '<meta property="og:image:secure_url" content="' . esc_url($seo['og_image']) . "\" />\n";
    echo '<meta property="og:image:width" content="' . esc_attr((string) $img['width']) . "\" />\n";
    echo '<meta property="og:image:height" content="' . esc_attr((string) $img['height']) . "\" />\n";
    echo '<meta property="og:image:alt" content="' . esc_attr($seo['og_title']) . "\" />\n";
    if (!empty($img['type'])) {
        echo '<meta property="og:image:type" content="' . esc_attr($img['type']) . "\" />\n";
    }

    if (is_singular('post')) {
        $post = get_queried_object();
        if ($post instanceof WP_Post) {
            echo '<meta property="article:published_time" content="' . esc_attr(get_the_date('c', $post)) . "\" />\n";
            echo '<meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c', $post)) . "\" />\n";
            $author = get_post_meta($post->ID, '_ahavat_author', true);
            if ($author) {
                echo '<meta property="article:author" content="' . esc_attr($author) . "\" />\n";
            }
            echo '<meta property="article:section" content="מאמרים" />' . "\n";
        }
    }

    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($seo['og_title']) . "\" />\n";
    echo '<meta name="twitter:description" content="' . esc_attr($seo['og_description']) . "\" />\n";
    echo '<meta name="twitter:image" content="' . esc_url($seo['og_image']) . "\" />\n";
    echo '<meta name="twitter:image:alt" content="' . esc_attr($seo['og_title']) . "\" />\n";
}, 2);

function ahavat_google_site_verification() {
    $id = get_theme_mod('ahavat_google_site_verification', '');
    if ($id) {
        return sanitize_text_field($id);
    }
    if (defined('AHAVAT_GOOGLE_SITE_VERIFICATION') && AHAVAT_GOOGLE_SITE_VERIFICATION) {
        return AHAVAT_GOOGLE_SITE_VERIFICATION;
    }
    return '';
}

function ahavat_jsonld_business() {
    $logo = ahavat_img('logo');
    $image = ahavat_seo_default_image();
    return [
        '@type' => ['VeterinaryCare', 'LocalBusiness', 'MedicalBusiness'],
        '@id' => home_url('/#clinic'),
        'name' => 'אהבת החי',
        'alternateName' => ['Ahavat HaChai', 'מרכז וטרינרי אהבת החי'],
        'description' => 'מרכז וטרינרי בצפון תל אביב בניהולו של ד״ר עופר שביט. טיפול בכלבים, חתולים, ארנבים, מכרסמים, ציפורים וחיות אקזוטיות.',
        'url' => home_url('/'),
        'image' => $image,
        'logo' => $logo,
        'telephone' => AHAVAT_PHONE_TEL,
        'email' => AHAVAT_EMAIL_VET,
        'priceRange' => '$$',
        'currenciesAccepted' => 'ILS',
        'paymentAccepted' => 'Cash, Credit Card',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'יד המעביר 9',
            'addressLocality' => 'תל אביב-יפו',
            'addressRegion' => 'הדר יוסף',
            'postalCode' => '69710',
            'addressCountry' => 'IL',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => (float) AHAVAT_LAT,
            'longitude' => (float) AHAVAT_LNG,
        ],
        'hasMap' => AHAVAT_MAPS,
        'areaServed' => [
            '@type' => 'City',
            'name' => 'תל אביב-יפו',
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
        'contactPoint' => [
            [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'telephone' => AHAVAT_PHONE_TEL,
                'email' => AHAVAT_EMAIL_OFFICE,
                'availableLanguage' => ['Hebrew', 'English'],
                'areaServed' => 'IL',
            ],
            [
                '@type' => 'ContactPoint',
                'contactType' => 'emergency',
                'telephone' => AHAVAT_EMERGENCY_TEL,
                'availableLanguage' => 'Hebrew',
                'hoursAvailable' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'],
                    'opens' => '19:00',
                    'closes' => '08:30',
                ],
            ],
        ],
        'sameAs' => [AHAVAT_FB, AHAVAT_IG],
        'founder' => [
            '@type' => 'Person',
            'name' => 'ד״ר עופר שביט',
            'jobTitle' => 'וטרינר, מייסד',
        ],
        'knowsLanguage' => ['he', 'en'],
        'medicalSpecialty' => ['Veterinary', 'Surgery', 'Oncology', 'Dentistry'],
    ];
}

function ahavat_jsonld_website() {
    return [
        '@type' => 'WebSite',
        '@id' => home_url('/#website'),
        'url' => home_url('/'),
        'name' => 'אהבת החי',
        'inLanguage' => 'he-IL',
        'publisher' => ['@id' => home_url('/#clinic')],
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => home_url('/search/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string',
        ],
    ];
}

function ahavat_jsonld_breadcrumbs($seo, $url) {
    $items = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'דף הבית',
            'item' => home_url('/'),
        ],
    ];
    if (is_front_page()) {
        return null;
    }
    if (is_singular('post')) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'מאמרים',
            'item' => home_url('/mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym/'),
        ];
        $items[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => get_the_title(),
            'item' => $url,
        ];
    } elseif (is_page()) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => get_the_title(),
            'item' => $url,
        ];
    } else {
        $items[] = [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $seo['title'],
            'item' => $url,
        ];
    }
    return [
        '@type' => 'BreadcrumbList',
        '@id' => ($url ?: home_url('/')) . '#breadcrumb',
        'itemListElement' => $items,
    ];
}

function ahavat_jsonld_faq() {
    $q = new WP_Query([
        'post_type' => 'faq_item',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'no_found_rows' => true,
    ]);
    $entities = [];
    while ($q->have_posts()) {
        $q->the_post();
        $answer = trim(wp_strip_all_tags(get_the_content()));
        if (!$answer) {
            continue;
        }
        $entities[] = [
            '@type' => 'Question',
            'name' => get_the_title(),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $answer,
            ],
        ];
    }
    wp_reset_postdata();
    if (!$entities) {
        return null;
    }
    return [
        '@type' => 'FAQPage',
        'mainEntity' => $entities,
    ];
}

add_action('wp_head', function () {
    $seo = ahavat_seo_meta();
    $url = ahavat_canonical_url() ?: home_url('/');
    $graph = [
        ahavat_jsonld_business(),
        ahavat_jsonld_website(),
    ];

    $webpage = [
        '@type' => is_singular('post') ? 'Article' : 'WebPage',
        '@id' => $url . '#webpage',
        'url' => $url,
        'name' => $seo['title'],
        'description' => $seo['description'],
        'inLanguage' => 'he-IL',
        'isPartOf' => ['@id' => home_url('/#website')],
        'about' => ['@id' => home_url('/#clinic')],
        'primaryImageOfPage' => $seo['og_image'],
    ];
    if (is_singular('post')) {
        $post = get_queried_object();
        $webpage['headline'] = get_the_title();
        $webpage['datePublished'] = get_the_date('c', $post);
        $webpage['dateModified'] = get_the_modified_date('c', $post);
        $author = get_post_meta($post->ID, '_ahavat_author', true) ?: 'אהבת החי';
        $webpage['author'] = [
            '@type' => 'Person',
            'name' => $author,
        ];
        $webpage['publisher'] = ['@id' => home_url('/#clinic')];
        $webpage['image'] = $seo['og_image'];
        $webpage['mainEntityOfPage'] = $url;
    }
    $graph[] = $webpage;

    $crumbs = ahavat_jsonld_breadcrumbs($seo, $url);
    if ($crumbs) {
        $graph[] = $crumbs;
    }

    if (is_page('fqa')) {
        $faq = ahavat_jsonld_faq();
        if ($faq) {
            $graph[] = $faq;
        }
    }

    $data = [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];
    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}, 20);

add_filter('wp_sitemaps_posts_query_args', function ($args, $post_type) {
    if (!in_array($post_type, ['page', 'post'], true)) {
        return $args;
    }
    $noindex = get_posts([
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_key' => '_ahavat_robots',
        'meta_value' => 'noindex, follow',
        'suppress_filters' => true,
    ]);
    if ($noindex) {
        $args['post__not_in'] = array_merge((array) ($args['post__not_in'] ?? []), $noindex);
    }
    return $args;
}, 10, 2);

add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('ahavat_seo', [
        'title' => 'SEO',
        'priority' => 161,
    ]);
    $wp_customize->add_setting('ahavat_google_site_verification', [
        'default' => defined('AHAVAT_GOOGLE_SITE_VERIFICATION') ? AHAVAT_GOOGLE_SITE_VERIFICATION : '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ahavat_google_site_verification', [
        'label' => 'Google Search Console verification',
        'description' => 'תוכן המטא google-site-verification מהאתר החי.',
        'section' => 'ahavat_seo',
        'type' => 'text',
    ]);
});

add_action('add_meta_boxes', function () {
    add_meta_box('ahavat_seo', 'SEO', function ($post) {
        wp_nonce_field('ahavat_seo', 'ahavat_seo_nonce');
        $title = get_post_meta($post->ID, '_ahavat_seo_title', true);
        $desc = get_post_meta($post->ID, '_ahavat_seo_description', true);
        $og_title = get_post_meta($post->ID, '_ahavat_og_title', true);
        $og_desc = get_post_meta($post->ID, '_ahavat_og_description', true);
        $og = get_post_meta($post->ID, '_ahavat_og_image', true);
        $robots = get_post_meta($post->ID, '_ahavat_robots', true);
        echo '<p><label>כותרת SEO<br><input type="text" name="ahavat_seo_title" value="' . esc_attr($title) . '" class="widefat" maxlength="70" /></label></p>';
        echo '<p><label>תיאור מטא<br><textarea name="ahavat_seo_description" class="widefat" rows="3" maxlength="180">' . esc_textarea($desc) . '</textarea></label></p>';
        echo '<p><label>כותרת Open Graph<br><input type="text" name="ahavat_og_title" value="' . esc_attr($og_title) . '" class="widefat" /></label></p>';
        echo '<p><label>תיאור Open Graph<br><textarea name="ahavat_og_description" class="widefat" rows="2">' . esc_textarea($og_desc) . '</textarea></label></p>';
        echo '<p><label>תמונת Open Graph (שם קובץ בתיקיית התמה)<br><input type="text" name="ahavat_og_image" value="' . esc_attr($og) . '" class="widefat" /></label></p>';
        echo '<p><label><input type="checkbox" name="ahavat_noindex" value="1" ' . checked($robots, 'noindex, follow', false) . ' /> הסתר ממנועי חיפוש (noindex)</label></p>';
    }, ['page', 'post', 'team_member'], 'normal');
});

add_action('save_post', function ($post_id) {
    if (!isset($_POST['ahavat_seo_nonce']) || !wp_verify_nonce($_POST['ahavat_seo_nonce'], 'ahavat_seo')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $fields = [
        'ahavat_seo_title' => '_ahavat_seo_title',
        'ahavat_og_title' => '_ahavat_og_title',
        'ahavat_og_image' => '_ahavat_og_image',
    ];
    foreach ($fields as $input => $meta) {
        if (isset($_POST[$input])) {
            update_post_meta($post_id, $meta, sanitize_text_field(wp_unslash($_POST[$input])));
        }
    }
    if (isset($_POST['ahavat_seo_description'])) {
        update_post_meta($post_id, '_ahavat_seo_description', sanitize_textarea_field(wp_unslash($_POST['ahavat_seo_description'])));
    }
    if (isset($_POST['ahavat_og_description'])) {
        update_post_meta($post_id, '_ahavat_og_description', sanitize_textarea_field(wp_unslash($_POST['ahavat_og_description'])));
    }
    if (!empty($_POST['ahavat_noindex'])) {
        update_post_meta($post_id, '_ahavat_robots', 'noindex, follow');
    } else {
        delete_post_meta($post_id, '_ahavat_robots');
    }
});
