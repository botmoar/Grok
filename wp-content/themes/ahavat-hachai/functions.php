<?php
/**
 * Ahavat HaChai theme bootstrap.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('AHAVAT_VERSION', '1.1.0');
define('AHAVAT_PHONE_DISPLAY', '03-6472933');
define('AHAVAT_PHONE_TEL', '+97236472933');
define('AHAVAT_EMERGENCY_DISPLAY', '077-9579799');
define('AHAVAT_EMERGENCY_TEL', '+972779579799');
define('AHAVAT_EMERGENCY_HOME_DISPLAY', '054-344600');
define('AHAVAT_EMERGENCY_HOME_TEL', '+97254344600');
define('AHAVAT_WHATSAPP_DISPLAY', '053-3535306');
define('AHAVAT_WHATSAPP_E164', '972533535306');
define('AHAVAT_WHATSAPP_TEXT', 'ברוכים הבאים לאהבת החי');
define('AHAVAT_EMAIL_VET', 'vet@ofervet.co.il');
define('AHAVAT_EMAIL_OFFICE', 'office@ofervet.co.il');
define('AHAVAT_ADDRESS', 'יד המעביר 9 הדר יוסף, תל אביב');
define('AHAVAT_LAT', '32.10908');
define('AHAVAT_LNG', '34.82452');
define('AHAVAT_FB', 'https://www.facebook.com/ofervet?locale=he_IL');
define('AHAVAT_IG', 'https://www.instagram.com/ofervet/');
define('AHAVAT_MAPS', 'https://www.google.com/maps/place/%D7%90%D7%94%D7%91%D7%AA+%D7%94%D7%97%D7%99/@32.1090852,34.8245198,17z');

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/cpt.php';
require get_template_directory() . '/inc/seo.php';

add_action('after_setup_theme', function () {
    load_theme_textdomain('ahavat-hachai', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height' => 80,
        'width' => 220,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    register_nav_menus([
        'primary' => 'תפריט ראשי',
        'services' => 'עוד על השירותים שלנו',
    ]);
    add_image_size('ahavat-card', 800, 800, true);
    add_image_size('ahavat-hero', 1920, 1080, true);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'ahavat-fonts',
        'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'ahavat-main',
        get_theme_file_uri('assets/css/main.css'),
        ['ahavat-fonts'],
        AHAVAT_VERSION
    );
    wp_enqueue_script(
        'ahavat-main',
        get_theme_file_uri('assets/js/main.js'),
        [],
        AHAVAT_VERSION,
        true
    );
});

add_filter('language_attributes', function ($output) {
    return 'lang="he" dir="rtl"';
});

add_filter('locale', function ($locale) {
    return 'he_IL';
});

add_action('init', function () {
    add_rewrite_rule('^search/?$', 'index.php?s=', 'top');
    add_rewrite_rule('^rpvh-ltrntybyt-bb-ly-khyym/?$', 'index.php?ahavat_redirect=alternative-treatment', 'top');
});

add_filter('request', function ($vars) {
    $path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    if (preg_match('#^articles/(.+?)/?$#u', $path, $m)) {
        global $wpdb;
        $id = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = 'post' AND post_status = 'publish' LIMIT 1",
            $m[1]
        ));
        if ($id) {
            return ['p' => $id];
        }
        $vars['name'] = $m[1];
        $vars['post_type'] = 'post';
    }
    return $vars;
});

add_filter('query_vars', function ($vars) {
    $vars[] = 'ahavat_redirect';
    $vars[] = 'query';
    return $vars;
});

add_action('template_redirect', function () {
    $path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    if ($path === 'rpvh-ltrntybyt-bb-ly-khyym' || get_query_var('ahavat_redirect') === 'alternative-treatment') {
        wp_safe_redirect(home_url('/alternative-treatment/'), 301);
        exit;
    }
}, 0);

add_filter('pre_get_posts', function ($q) {
    if ($q->is_search() && $q->is_main_query() && empty($q->get('s'))) {
        $alt = get_query_var('query');
        if ($alt) {
            $q->set('s', sanitize_text_field($alt));
        }
    }
});

add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('ahavat_tracking', [
        'title' => 'מעקב (GTM)',
        'priority' => 160,
    ]);
    $wp_customize->add_setting('ahavat_gtm_id', [
        'default' => defined('AHAVAT_GTM_ID') ? AHAVAT_GTM_ID : '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ahavat_gtm_id', [
        'label' => 'Google Tag Manager ID',
        'description' => 'לדוגמה GTM-5S4LVXQ6. השאירו ריק בסביבה מקומית.',
        'section' => 'ahavat_tracking',
        'type' => 'text',
    ]);
});

add_filter('robots_txt', function ($output, $public) {
    if (!$public) {
        return "User-agent: *\nDisallow: /\n";
    }
    $home = home_url('/');
    return "User-agent: *\n"
        . "Allow: /\n"
        . "Disallow: /wp-admin/\n"
        . "Allow: /wp-admin/admin-ajax.php\n"
        . "Disallow: /wp-login.php\n\n"
        . "Sitemap: {$home}wp-sitemap.xml\n";
}, 10, 2);

add_filter('wp_sitemaps_enabled', '__return_true');

add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
    if ($name === 'users') {
        return false;
    }
    return $provider;
}, 10, 2);

add_filter('wp_sitemaps_post_types', function ($types) {
    unset($types['team_member'], $types['faq_item']);
    return $types;
});

add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
    unset($taxonomies['category'], $taxonomies['post_tag'], $taxonomies['faq_category']);
    return $taxonomies;
});

add_filter('the_content', function ($content) {
    return ahavat_replace_theme_img_placeholder($content);
});

add_action('wp_head', function () {
    $gtm = ahavat_gtm_id();
    if (!$gtm) {
        return;
    }
    ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo esc_js($gtm); ?>');</script>
    <?php
}, 1);

add_action('wp_body_open', function () {
    $gtm = ahavat_gtm_id();
    if (!$gtm) {
        return;
    }
    echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . esc_attr($gtm) . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
});
