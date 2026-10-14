<?php
/**
 * Amichai Marx theme.
 */

defined('ABSPATH') || exit;

require get_template_directory() . '/inc/seo.php';
require get_template_directory() . '/inc/schema.php';

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    register_nav_menus([
        'primary' => 'תפריט ראשי',
        'footer' => 'תפריט תחתון',
    ]);
});

function amichai_asset_src(string $path): array {
    $dir = get_template_directory();
    $min = preg_replace('/\.(css|js)$/', '.min.$1', $path);
    $use = (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) && file_exists($dir . '/' . $min)) ? $min : $path;
    $ver = file_exists($dir . '/' . $use) ? (string) filemtime($dir . '/' . $use) : '1.0.0';
    return [get_template_directory_uri() . '/' . $use, $ver];
}

add_action('wp_enqueue_scripts', function (): void {
    [$css, $css_ver] = amichai_asset_src('assets/css/main.css');
    wp_enqueue_style('amichai-main', $css, [], $css_ver);
    [$js, $js_ver] = amichai_asset_src('assets/js/main.js');
    wp_enqueue_script('amichai-main', $js, [], $js_ver, ['in_footer' => true, 'strategy' => 'defer']);

    if (is_page_template('template-budget.php')) {
        [$src, $ver] = amichai_asset_src('assets/js/budget.js');
        wp_enqueue_script('amichai-budget', $src, [], $ver, ['in_footer' => true, 'strategy' => 'defer']);
    }
    if (is_page_template('template-savings.php')) {
        [$src, $ver] = amichai_asset_src('assets/css/savings.css');
        wp_enqueue_style('amichai-savings', $src, ['amichai-main'], $ver);
        wp_enqueue_script('chartjs', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js', [], '4.4.1', ['in_footer' => true, 'strategy' => 'defer']);
        [$src, $ver] = amichai_asset_src('assets/js/savings.js');
        wp_enqueue_script('amichai-savings', $src, ['chartjs'], $ver, ['in_footer' => true, 'strategy' => 'defer']);
    }

    // Classic theme with no block content: core block and global styles are dead weight.
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
}, 20);

// Generated image sizes are written as WebP; originals stay as uploaded.
add_filter('image_editor_output_format', static function (array $formats): array {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png'] = 'image/webp';
    return $formats;
});

add_action('wp_head', function (): void {
    $uri = get_template_directory_uri() . '/assets/fonts/';
    foreach (['heebo-400', 'heebo-700', 'heebo-800'] as $font) {
        echo '<link rel="preload" href="' . esc_url($uri . $font . '.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";
    }
}, 2);

add_action('init', function (): void {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_enqueue_scripts', 'wp_enqueue_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('emoji_svg_url', '__return_false');
    // Theme prints PNG icons in header.php; core would print WebP crops iOS ignores.
    remove_action('wp_head', 'wp_site_icon', 99);
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('template_redirect', 'rest_output_link_header', 11);
});

add_action('init', function (): void {
    register_post_type('amichai_lead', [
        'labels' => [
            'name' => 'פניות',
            'singular_name' => 'פנייה',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email',
        'supports' => ['title', 'editor', 'custom-fields'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
    ]);

    amichai_register_root_category_rules();
});

function amichai_register_root_category_rules(): void {
    $categories = get_categories(['hide_empty' => false]);
    if (!is_array($categories)) {
        return;
    }
    foreach ($categories as $cat) {
        $slug = $cat->slug;
        $clash = get_posts([
            'name' => $slug,
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'fields' => 'ids',
        ]);
        if ($clash) {
            continue;
        }
        $paths = [$slug];
        $decoded = rawurldecode($slug);
        if ($decoded !== $slug) {
            $paths[] = $decoded;
        }
        foreach ($paths as $path) {
            $quoted = preg_quote($path, '/');
            add_rewrite_rule('^' . $quoted . '/?$', 'index.php?category_name=' . $slug, 'top');
            add_rewrite_rule('^' . $quoted . '/page/([0-9]{1,})/?$', 'index.php?category_name=' . $slug . '&paged=$matches[1]', 'top');
        }
    }
}

add_filter('category_link', function (string $link, $term_id): string {
    $cat = get_category($term_id);
    if (!$cat || is_wp_error($cat)) {
        return $link;
    }
    $clash = get_posts([
        'name' => $cat->slug,
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'fields' => 'ids',
    ]);
    if ($clash) {
        return $link;
    }
    return home_url('/' . $cat->slug . '/');
}, 10, 2);

// The mortgage category only groups the topic pages; its archive would compete with the hub.
add_action('template_redirect', function (): void {
    if (is_category('משכנתאות')) {
        wp_safe_redirect(home_url('/דיור-ומשכנתאות/'), 301);
        exit;
    }
});

add_filter('wp_sitemaps_taxonomies_query_args', function (array $args, string $taxonomy): array {
    if ($taxonomy === 'category') {
        $term = get_term_by('name', 'משכנתאות', 'category');
        if ($term) {
            $args['exclude'] = array_merge((array) ($args['exclude'] ?? []), [(int) $term->term_id]);
        }
    }
    return $args;
}, 10, 2);

add_action('admin_post_nopriv_amichai_lead', 'amichai_handle_lead');
add_action('admin_post_amichai_lead', 'amichai_handle_lead');

function amichai_handle_lead(): void {
    $back = wp_get_referer() ?: home_url('/צור-קשר/');
    $back = remove_query_arg(['lead'], $back);

    if (!isset($_POST['amichai_lead_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['amichai_lead_nonce'])), 'amichai_lead')) {
        wp_safe_redirect(add_query_arg('lead', 'err', $back));
        exit;
    }
    $started = isset($_POST['amichai_t']) ? (int) $_POST['amichai_t'] : 0;
    $too_fast = $started <= 0 || (time() - $started) < 3;
    if (!empty($_POST['company_website']) || $too_fast) {
        wp_safe_redirect(add_query_arg('lead', 'ok', home_url('/צור-קשר/')) . '#am-lead-status');
        exit;
    }

    $name = isset($_POST['full_name']) ? sanitize_text_field(wp_unslash($_POST['full_name'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
    $consent = !empty($_POST['privacy_ok']);

    if ($name === '' || $phone === '' || !$consent) {
        wp_safe_redirect(add_query_arg('lead', 'err', $back) . '#am-lead-status');
        exit;
    }

    $id = wp_insert_post([
        'post_type' => 'amichai_lead',
        'post_status' => 'private',
        'post_title' => $name . ' – ' . $phone,
        'post_content' => $message,
    ], true);

    if (!is_wp_error($id)) {
        update_post_meta($id, 'phone', $phone);
        update_post_meta($id, 'email', $email);
        $body = "שם: {$name}\nטלפון: {$phone}\nדוא״ל: {$email}\n\n{$message}";
        $headers = $email !== '' && is_email($email) ? ['Reply-To: ' . $name . ' <' . $email . '>'] : [];
        $to = (string) apply_filters('amichai_lead_recipient', 'marx@amichai-marx.co.il');
        $sent = wp_mail($to, 'פנייה חדשה מהאתר: ' . $name, $body, $headers);
        update_post_meta($id, 'mail_sent', $sent ? '1' : '0');
    }

    wp_safe_redirect(add_query_arg('lead', 'ok', home_url('/צור-קשר/')) . '#am-lead-status');
    exit;
}

add_action('customize_register', function (WP_Customize_Manager $wp_customize): void {
    $wp_customize->add_section('amichai_analytics', [
        'title' => 'אנליטיקס',
        'priority' => 160,
    ]);
    $wp_customize->add_setting('amichai_ga4_id', [
        'default' => 'G-5SR358LG0Z',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_setting('amichai_ga4_enabled', [
        'default' => false,
        'sanitize_callback' => static fn ($value): bool => (bool) $value,
    ]);
    $wp_customize->add_control('amichai_ga4_id', [
        'label' => 'מזהה GA4',
        'section' => 'amichai_analytics',
        'type' => 'text',
    ]);
    $wp_customize->add_control('amichai_ga4_enabled', [
        'label' => 'הפעלת Google Analytics',
        'description' => 'כבוי כברירת מחדל בתצוגה המקדימה. מפעילים רק אחרי עלייה לאוויר.',
        'section' => 'amichai_analytics',
        'type' => 'checkbox',
    ]);
});

add_action('wp_head', function (): void {
    if (is_admin() || !get_theme_mod('amichai_ga4_enabled')) {
        return;
    }
    $id = (string) get_theme_mod('amichai_ga4_id', '');
    if (!preg_match('/^G-[A-Z0-9]+$/', $id)) {
        return;
    }
    $src = esc_url('https://www.googletagmanager.com/gtag/js?id=' . rawurlencode($id));
    echo '<script async src="' . $src . '"></script>' . "\n";
    echo '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","' . esc_js($id) . '");</script>' . "\n";
}, 20);

/**
 * Primary nav and footer crawl map. Labels match live intent; URLs are kept slugs only.
 * /ייעוץ-כלכלי/ and /תחומי-כלכלת-המשפחה/ 301 to /יועץ-לכלכלת-המשפחה/, so they are not menu items.
 *
 * @return array<int, array<string, mixed>>
 */
function amichai_primary_menu_tree(): array {
    return [
        ['label' => 'אודות', 'slug' => 'אודות', 'type' => 'page', 'children' => [
            ['label' => 'סיפורי משפחות', 'slug' => 'סיפורי-משפחות', 'type' => 'post'],
            ['label' => 'מן התקשורת', 'slug' => 'מן-התקשורת', 'type' => 'page'],
            ['label' => 'הרצאות וסדנאות', 'slug' => 'הרצאות-וסדנאות', 'type' => 'post'],
        ]],
        ['label' => 'ייעוץ כלכלי', 'slug' => 'יועץ-לכלכלת-המשפחה', 'type' => 'post', 'children' => [
            ['label' => 'למי מיועד הייעוץ?', 'slug' => 'למי-מיועד-הייעוץ', 'type' => 'post'],
            ['label' => 'ליווי צמוד לאורך הדרך', 'slug' => 'ליווי', 'type' => 'post'],
            ['label' => 'כלכלת משפחה', 'slug' => 'כלכלת-משפחה', 'type' => 'post'],
            ['label' => 'חיים במינוס', 'slug' => 'חיים-במינוס', 'type' => 'post'],
        ]],
        ['label' => 'משכנתאות', 'slug' => 'דיור-ומשכנתאות', 'type' => 'post', 'class' => 'am-menu-key am-mega', 'children' => amichai_mortgage_menu_children()],
        ['label' => 'צמיחה וחסכונות', 'slug' => 'חסכונות', 'type' => 'post'],
        ['label' => 'דילמות כלכליות', 'slug' => 'דילמות-כלכליות', 'type' => 'post', 'children' => [
            ['label' => 'פנסיה', 'slug' => 'פנסיה', 'type' => 'post'],
            ['label' => 'ביטוחים', 'slug' => 'ביטוחים', 'type' => 'post'],
            ['label' => 'יציאה מחובות', 'slug' => 'יציאה-מחובות', 'type' => 'post'],
        ]],
        ['label' => 'מאמרים', 'type' => 'custom', 'path' => '/מאמרים/'],
        ['label' => 'כלי עזר', 'slug' => 'כלי-עזר', 'type' => 'page', 'children' => [
            ['label' => 'מחשבון תקציב משפחתי', 'slug' => 'מחשבון-תקציב-משפחתי', 'type' => 'page'],
            ['label' => 'מחשבון חיסכון משפחתי ליעדים', 'slug' => 'מחשבון-חיסכון-משפחתי-ליעדים', 'type' => 'page'],
        ]],
        ['label' => 'צור קשר', 'slug' => 'צור-קשר', 'type' => 'page'],
    ];
}

/**
 * The mortgage pillar: four groups by life situation, thirteen topic pages (seeded from
 * tools/mortgage_topics.py). Drives the mega menu, the topic maps, the footer and schema.
 *
 * @return array<string, array<string, mixed>>
 */
function amichai_mortgage_groups(): array {
    return [
        'buy' => [
            'title' => 'קונים בית',
            'text' => 'דירה ראשונה, שדרוג, בנייה ושיפוץ.',
            'icon' => 'M3 11.5 12 4l9 7.5M5.5 9.8V20h13V9.8M10 20v-5.5h4V20',
            'items' => [
                ['slug' => 'יועץ-משכנתאות-לזוגות-צעירים', 'label' => 'זוגות צעירים ודירה ראשונה'],
                ['slug' => 'משכנתא-למשפרי-דיור', 'label' => 'משפרי דיור'],
                ['slug' => 'משכנתא-לבנייה-עצמית', 'label' => 'בנייה עצמית'],
                ['slug' => 'משכנתא-לשיפוץ', 'label' => 'שיפוץ ושדרוג הבית'],
            ],
        ],
        'save' => [
            'title' => 'חוסכים במשכנתא',
            'text' => 'מחזור, עלויות, ואיחוד הלוואות וחובות.',
            'icon' => 'M4 16.5 9.5 11l3.5 3.5L20 7.5M15 7.5h5v5',
            'items' => [
                ['slug' => 'מחזור-משכנתא', 'label' => 'מחזור משכנתא'],
                ['slug' => 'חיסכון-בעלויות-המשכנתא', 'label' => 'חיסכון בעלויות המשכנתא'],
                ['slug' => 'איחוד-הלוואות', 'label' => 'איחוד הלוואות וחובות'],
            ],
        ],
        'special' => [
            'title' => 'מקרים מיוחדים',
            'text' => 'אחרי סירוב, אחרי גיל 50, ומשכנתא הפוכה.',
            'icon' => 'M12 3.5 19.5 6v5.5c0 4.4-3.1 8-7.5 9-4.4-1-7.5-4.6-7.5-9V6L12 3.5ZM9 12l2.2 2.2L15.5 10',
            'items' => [
                ['slug' => 'יועץ-משכנתאות-למסורבים', 'label' => 'משכנתא למסורבים'],
                ['slug' => 'משכנתא-למבוגרים', 'label' => 'משכנתא אחרי גיל 50'],
                ['slug' => 'משכנתא-הפוכה', 'label' => 'משכנתא הפוכה'],
            ],
        ],
        'personal' => [
            'title' => 'ייעוץ אישי',
            'text' => 'יועץ משכנתאות פרטי, הלוואות, וייעוץ באזור.',
            'icon' => 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4.5 20.5c.8-3.8 3.8-6 7.5-6s6.7 2.2 7.5 6',
            'items' => [
                ['slug' => 'יועץ-משכנתאות-פרטי', 'label' => 'יועץ משכנתאות פרטי'],
                ['slug' => 'יועץ-הלוואות-פרטי', 'label' => 'יועץ הלוואות פרטי'],
                ['slug' => 'יועץ-משכנתאות-בצפון', 'label' => 'יועץ משכנתאות בצפון'],
            ],
        ],
    ];
}

function amichai_mortgage_menu_children(): array {
    $children = [];
    foreach (amichai_mortgage_groups() as $key => $group) {
        $children[] = [
            'label' => $group['title'],
            'type' => 'custom',
            'path' => '/דיור-ומשכנתאות/#mortgage-' . $key,
            'class' => 'am-mega-group',
            'children' => array_map(static fn (array $item): array => $item + ['type' => 'post'], $group['items']),
        ];
    }
    return $children;
}

/**
 * @return array{group: string, title: string, label: string}|null
 */
function amichai_mortgage_topic(string $slug): ?array {
    foreach (amichai_mortgage_groups() as $key => $group) {
        foreach ($group['items'] as $item) {
            if ($item['slug'] === $slug) {
                return ['group' => $key, 'title' => $group['title'], 'label' => $item['label']];
            }
        }
    }
    return null;
}

function amichai_is_mortgage_topic(int $post_id): bool {
    return amichai_mortgage_topic(rawurldecode((string) get_post_field('post_name', $post_id))) !== null;
}

function amichai_mortgage_icon(string $path): string {
    return '<svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="' . esc_attr($path) . '"/></svg>';
}

function amichai_mortgage_map(string $current = ''): void {
    ?>
    <div class="am-mmap">
      <?php foreach (amichai_mortgage_groups() as $key => $group) : ?>
        <section class="am-mmap-group" id="mortgage-<?php echo esc_attr($key); ?>" aria-labelledby="am-mmap-<?php echo esc_attr($key); ?>">
          <span class="am-mmap-icon"><?php echo amichai_mortgage_icon($group['icon']); ?></span>
          <h3 id="am-mmap-<?php echo esc_attr($key); ?>"><?php echo esc_html($group['title']); ?></h3>
          <p><?php echo esc_html($group['text']); ?></p>
          <ul>
            <?php foreach ($group['items'] as $item) : ?>
              <li><a href="<?php echo esc_url(home_url('/' . $item['slug'] . '/')); ?>"<?php echo $item['slug'] === $current ? ' aria-current="page"' : ''; ?>><?php echo esc_html($item['label']); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </section>
      <?php endforeach; ?>
    </div>
    <?php
}

/**
 * @return array<int, array{q: string, a: string}>
 */
function amichai_post_faq(int $post_id): array {
    $faq = json_decode((string) get_post_meta($post_id, '_amichai_faq', true), true);
    if (!is_array($faq)) {
        return [];
    }
    return array_values(array_filter($faq, static fn ($row) => is_array($row) && !empty($row['q']) && !empty($row['a'])));
}

function amichai_mortgage_trust_line(): void {
    ?>
    <p class="am-trust-line">
      <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 3.5 19.5 6v5.5c0 4.4-3.1 8-7.5 9-4.4-1-7.5-4.6-7.5-9V6L12 3.5ZM9 12l2.2 2.2L15.5 10"/></svg>
      <span>עמיחי מרקס, יועץ משכנתאות. <a href="<?php echo esc_url(home_url('/דיור-ומשכנתאות/#mortgage-cert')); ?>">חבר בהתאחדות יועצי המשכנתאות בישראל</a> · 15 שנה בליווי משפחות</span>
    </p>
    <?php
}

function amichai_menu_item_url(array $item): string {
    if (($item['type'] ?? '') === 'custom') {
        return home_url((string) ($item['path'] ?? '/'));
    }
    $slug = (string) ($item['slug'] ?? '');
    return home_url('/' . $slug . '/');
}

function amichai_render_fallback_item(array $item): void {
    $children = $item['children'] ?? [];
    $classes = trim(($children ? 'menu-item-has-children ' : '') . ($item['class'] ?? ''));
    $class = $classes !== '' ? ' class="' . esc_attr($classes) . '"' : '';
    echo '<li' . $class . '><a href="' . esc_url(amichai_menu_item_url($item)) . '">' . esc_html((string) $item['label']) . '</a>';
    if ($children) {
        echo '<ul class="sub-menu">';
        foreach ($children as $child) {
            amichai_render_fallback_item($child);
        }
        echo '</ul>';
    }
    echo '</li>';
}

function amichai_fallback_menu(): void {
    echo '<ul class="am-menu">';
    foreach (amichai_primary_menu_tree() as $item) {
        amichai_render_fallback_item($item);
    }
    echo '</ul>';
}

function amichai_render_flat_links(array $items): void {
    echo '<ul>';
    foreach ($items as $item) {
        echo '<li><a href="' . esc_url(amichai_menu_item_url($item)) . '">' . esc_html((string) $item['label']) . '</a></li>';
    }
    echo '</ul>';
}

function amichai_footer_service_links(): array {
    return [
        ['label' => 'ייעוץ משכנתאות', 'slug' => 'דיור-ומשכנתאות', 'type' => 'post'],
        ['label' => 'ייעוץ כלכלי למשפחה', 'slug' => 'יועץ-לכלכלת-המשפחה', 'type' => 'post'],
        ['label' => 'צמיחה, חסכונות והשקעות', 'slug' => 'חסכונות', 'type' => 'post'],
        ['label' => 'ליווי צמוד', 'slug' => 'ליווי', 'type' => 'post'],
        ['label' => 'חיים במינוס', 'slug' => 'חיים-במינוס', 'type' => 'post'],
        ['label' => 'פנסיה', 'slug' => 'פנסיה', 'type' => 'post'],
        ['label' => 'ביטוחים', 'slug' => 'ביטוחים', 'type' => 'post'],
    ];
}

/**
 * Scans of the certificates. The ID number is masked in the image files themselves.
 *
 * @return array<string, array<string, mixed>>
 */
function amichai_certificates(): array {
    return [
        'mortgage' => [
            'file' => 'mortgage-association-2026',
            'w' => 1600, 'h' => 1131, 'tw' => 560, 'th' => 396,
            'title' => 'תעודת חבר, התאחדות יועצי המשכנתאות בישראל',
            'meta' => 'יועצי מימון לדיור ע״ר · לשנת 2026',
        ],
        'family' => [
            'file' => 'family-economics-2013',
            'w' => 1142, 'h' => 1600, 'tw' => 400, 'th' => 560,
            'title' => 'הסמכה כיועץ וכמאמן לכלכלת המשפחה',
            'meta' => 'קבוצת אש לידור פילוסוף · 275 שעות · אוקטובר 2013',
        ],
        'coaching' => [
            'file' => 'life-coaching-2013',
            'w' => 1060, 'h' => 1484, 'tw' => 400, 'th' => 560,
            'title' => 'תעודת גמר Life coaching',
            'meta' => 'מסלול הכשרת מאמנים · 176 שעות אקדמיות · מוסד מוסמך על ידי לשכת המאמנים בישראל',
        ],
    ];
}

function amichai_cert_figure(string $key, string $class = ''): void {
    $certs = amichai_certificates();
    if (!isset($certs[$key])) {
        return;
    }
    $c = $certs[$key];
    $full = amichai_asset('assets/images/certs/' . $c['file'] . '.webp');
    $thumb = amichai_asset('assets/images/certs/' . $c['file'] . '-thumb.webp');
    ?>
    <figure class="am-cert <?php echo esc_attr($class); ?>">
      <a class="am-cert-frame" href="<?php echo esc_url($full); ?>" data-lightbox data-w="<?php echo (int) $c['w']; ?>" data-h="<?php echo (int) $c['h']; ?>" data-caption="<?php echo esc_attr($c['title'] . ' · ' . $c['meta']); ?>" aria-label="<?php echo esc_attr('הגדלת התעודה: ' . $c['title']); ?>">
        <img src="<?php echo esc_url($thumb); ?>" width="<?php echo (int) $c['tw']; ?>" height="<?php echo (int) $c['th']; ?>" loading="lazy" decoding="async" alt="<?php echo esc_attr($c['title']); ?>">
        <span class="am-cert-zoom" aria-hidden="true"><svg viewBox="0 0 24 24" width="18" height="18"><circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="m16 16 4.5 4.5M11 8v6M8 11h6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
      </a>
      <figcaption><strong><?php echo esc_html($c['title']); ?></strong><span><?php echo esc_html($c['meta']); ?></span></figcaption>
    </figure>
    <?php
}

function amichai_credentials_list(): void {
    ?>
    <ul class="am-creds">
      <li><strong>יועץ משכנתאות</strong><span>חבר בהתאחדות יועצי המשכנתאות בישראל</span></li>
      <li><strong>יועץ ומאמן לכלכלת המשפחה</strong><span>הסמכה בהיקף 275 שעות, 2013</span></li>
      <li><strong>רישיון לייעוץ פנסיוני</strong><span>דמי ניהול, כיסויים ומה שנשאר לגיל פרישה</span></li>
      <li><strong>מאמן מוסמך ומגשר מוסמך</strong><span>176 שעות אקדמיות במסלול הכשרת מאמנים</span></li>
      <li><strong>חבר באיגוד היועצים והמאמנים</strong><span>לכלכלת המשפחה בישראל</span></li>
    </ul>
    <?php
}

function amichai_portrait(string $class = 'am-portrait-card'): void {
    ?>
    <figure class="<?php echo esc_attr($class); ?>">
      <img src="<?php echo esc_url(amichai_asset('assets/images/amichai-marx.jpg')); ?>" width="236" height="314" alt="עמיחי מרקס, יועץ לכלכלת המשפחה ויועץ משכנתאות">
    </figure>
    <?php
}

/**
 * Hero copy, highlights and related links for the designed service hubs.
 *
 * @return array<string, mixed>
 */
function amichai_hub_profile(string $slug): array {
    $profiles = [
        'דיור-ומשכנתאות' => [
            'kicker' => 'ייעוץ משכנתאות',
            'tone' => 'navy',
            'cert' => 'mortgage',
            'highlights' => [
                ['לקנות או להמשיך לשכור', 'החלטה שנבדקת מול ההכנסות, ההון העצמי והיכולת לעמוד במשבר.'],
                ['תמהיל שנבנה בשבילכם', 'השוואה בין הצעות הבנקים, והחזר חודשי שהבית יכול לשאת.'],
                ['מחזור משכנתא', 'בדיקת הריבית וההחזר הקיימים מול מה שאפשר לקבל היום.'],
                ['ליווי צמוד לאורך הדרך', 'גם אחרי החתימה, כשהריבית או החיים משתנים.'],
            ],
            'related' => ['חסכונות', 'יועץ-לכלכלת-המשפחה', 'ליווי'],
        ],
        'חסכונות' => [
            'kicker' => 'חסכונות והשקעות',
            'tone' => 'green',
            'highlights' => [
                ['חיסכון עם יעד', 'סכום חודשי שנגזר מהיעדים של המשפחה, לא מהמקרה.'],
                ['איפה הכסף מושקע', 'תשואה, דמי ניהול ורמת סיכון של החסכונות הקיימים.'],
                ['חיסכון לילדים', 'בחירת מסלול בחיסכון לכל ילד ותוכנית להשכלה, חתונה ודיור.'],
                ['פנסיה כנכס', 'הנכס הפיננסי הגדול של רוב המשפחות, ודמי הניהול שעליו.'],
            ],
            'related' => ['חיסכון-לכל-ילד-כל-המידע-ומה-כדאי-לעשות', 'פנסיה', 'דיור-ומשכנתאות'],
        ],
    ];
    $profiles['ליווי'] = [
        'kicker' => 'ליווי צמוד',
        'tone' => 'green',
        'highlights' => [
            ['שיחה שבועית', 'על ההתקדמות, בעזרת הכלים שסיכמנו עליהם.'],
            ['מענה מהיר', 'לכל שאלה או בעיה, בטלפון או במייל.'],
            ['פגישות נוספות', 'כשעולה החלטה גדולה או משהו משתנה בבית.'],
            ['עד עצמאות', 'הליווי נמשך עד שיש ביטחון להמשיך לבד.'],
        ],
        'related' => ['פגישה-מס-1-היכרות', 'פגישה-מס-2-הצגת-התוכנית', 'פגישה-מס-3-יישום-התוכנית'],
    ];
    $default = [
        'kicker' => 'ייעוץ לכלכלת המשפחה',
        'tone' => 'paper',
        'highlights' => [],
        'related' => ['דיור-ומשכנתאות', 'חסכונות', 'ליווי'],
    ];
    return $profiles[$slug] ?? $default;
}

function amichai_post_by_slug(string $slug): ?WP_Post {
    $found = get_posts([
        'name' => sanitize_title($slug),
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ]);
    return $found ? $found[0] : null;
}

function amichai_card_image(WP_Post $post): void {
    $img = has_post_thumbnail($post) ? get_the_post_thumbnail($post, 'medium_large', ['alt' => '', 'loading' => 'lazy']) : '';
    if ($img !== '') {
        echo $img;
        return;
    }
    $label = '';
    foreach (get_the_category($post->ID) ?: [] as $cat) {
        if ($cat->name !== 'מאמרים') {
            $label = $cat->name;
            break;
        }
    }
    ?>
    <span class="am-thumb-fallback" aria-hidden="true">
      <img src="<?php echo esc_url(amichai_asset('assets/images/logo-mark.png')); ?>" alt="" width="56" height="56" loading="lazy">
      <span><?php echo esc_html($label !== '' ? $label : 'כלכלת המשפחה'); ?></span>
    </span>
    <?php
}

function amichai_topic_card(WP_Post $post, string $label = ''): void {
    ?>
    <a class="am-topic" href="<?php echo esc_url(get_permalink($post)); ?>">
      <span class="am-topic-thumb"><?php amichai_card_image($post); ?></span>
      <span class="am-topic-body">
        <strong><?php echo esc_html($label !== '' ? $label : get_the_title($post)); ?></strong>
        <span><?php echo esc_html(wp_trim_words(get_the_excerpt($post), 18)); ?></span>
      </span>
    </a>
    <?php
}

function amichai_closing_cta(string $title = 'אפשר להתחיל בשיחה', string $text = 'שיחת היכרות, בלי התחייבות. משם ממשיכים יחד, בליווי צמוד לאורך הדרך.'): void {
    ?>
    <section class="am-band-last">
      <div class="am-wrap">
        <div class="am-cta-band am-cta-close">
          <div>
            <h2><?php echo esc_html($title); ?></h2>
            <p><?php echo esc_html($text); ?></p>
            <p class="am-cta-meta"><span class="am-email" dir="ltr">marx@amichai-marx.co.il</span><span>תל מנשה 11, חיננית</span></p>
          </div>
          <div class="am-actions">
            <?php amichai_whatsapp_button(); ?>
            <a class="am-btn am-btn-on-dark" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת ייעוץ</a>
          </div>
        </div>
      </div>
    </section>
    <?php
}

function amichai_page_hero(string $title, string $lead = '', string $kicker = ''): void {
    ?>
    <header class="am-page-hero">
      <div class="am-wrap">
        <?php if ($kicker !== '') : ?><p class="am-kicker"><?php echo esc_html($kicker); ?></p><?php endif; ?>
        <h1 class="am-page-title"><?php echo esc_html($title); ?></h1>
        <?php if ($lead !== '') : ?><p class="am-page-lead"><?php echo esc_html($lead); ?></p><?php endif; ?>
      </div>
    </header>
    <?php
}

/**
 * Footer link columns. Labels are short so three columns fit a 390px screen; the
 * mega menu still links every mortgage topic.
 *
 * @return array<int, array{title: string, items: array<int, array<string, string>>}>
 */
function amichai_footer_columns(): array {
    return [
        [
            'title' => 'משכנתאות',
            'items' => [
                ['label' => 'ייעוץ משכנתאות', 'slug' => 'דיור-ומשכנתאות', 'type' => 'post'],
                ['label' => 'מחזור משכנתא', 'slug' => 'מחזור-משכנתא', 'type' => 'post'],
                ['label' => 'זוגות צעירים', 'slug' => 'יועץ-משכנתאות-לזוגות-צעירים', 'type' => 'post'],
                ['label' => 'מסורבי משכנתא', 'slug' => 'יועץ-משכנתאות-למסורבים', 'type' => 'post'],
                ['label' => 'איחוד הלוואות', 'slug' => 'איחוד-הלוואות', 'type' => 'post'],
            ],
        ],
        [
            'title' => 'שירותים',
            'items' => [
                ['label' => 'כלכלת המשפחה', 'slug' => 'יועץ-לכלכלת-המשפחה', 'type' => 'post'],
                ['label' => 'ליווי צמוד', 'slug' => 'ליווי', 'type' => 'post'],
                ['label' => 'חסכונות והשקעות', 'slug' => 'חסכונות', 'type' => 'post'],
                ['label' => 'חיים במינוס', 'slug' => 'חיים-במינוס', 'type' => 'post'],
                ['label' => 'פנסיה', 'slug' => 'פנסיה', 'type' => 'post'],
            ],
        ],
        [
            'title' => 'באתר',
            'items' => [
                ['label' => 'אודות', 'slug' => 'אודות', 'type' => 'page'],
                ['label' => 'סיפורי משפחות', 'slug' => 'סיפורי-משפחות', 'type' => 'post'],
                ['label' => 'מאמרים', 'type' => 'custom', 'path' => '/מאמרים/'],
                ['label' => 'כלי עזר', 'slug' => 'כלי-עזר', 'type' => 'page'],
                ['label' => 'מן התקשורת', 'slug' => 'מן-התקשורת', 'type' => 'page'],
            ],
        ],
    ];
}

function amichai_service_hub_slugs(): array {
    return [
        'יועץ-לכלכלת-המשפחה',
        'דילמות-כלכליות',
        'חיים-במינוס',
        'פנסיה',
        'ביטוחים',
        'חסכונות',
        'דיור-ומשכנתאות',
        'כלכלת-משפחה',
        'למי-מיועד-הייעוץ',
        'הרצאות-וסדנאות',
        'ליווי',
    ];
}

function amichai_is_service_hub(int $post_id): bool {
    $slug = rawurldecode((string) get_post_field('post_name', $post_id));
    return in_array($slug, amichai_service_hub_slugs(), true);
}

function amichai_split_article_lead(string $html): array {
    if (preg_match_all('/<p\b[^>]*>.*?<\/p>/is', $html, $matches, PREG_OFFSET_CAPTURE)) {
        foreach ($matches[0] as $match) {
            $text = trim(wp_strip_all_tags($match[0]));
            $text = str_replace("\xc2\xa0", '', $text);
            if ($text === '') {
                continue;
            }
            $end = $match[1] + strlen($match[0]);
            return [substr($html, 0, $end), ltrim(substr($html, $end))];
        }
    }
    return [$html, ''];
}

function amichai_article_html(): array {
    $raw = get_the_content(null, false);
    $html = apply_filters('the_content', $raw);
    $html = str_replace(']]>', ']]&gt;', $html);
    return amichai_split_article_lead($html);
}

function amichai_inline_featured(): void {
    if (!has_post_thumbnail()) {
        return;
    }
    echo '<figure class="am-featured">';
    echo get_the_post_thumbnail(null, 'large', [
        'class' => 'am-inline-photo',
        'alt' => get_the_title(),
    ]);
    echo '</figure>';
}

function amichai_whatsapp_url(): string {
    return 'https://wa.me/972542372417';
}

function amichai_whatsapp_button(string $class = 'am-btn am-btn-primary'): void {
    echo '<a class="' . esc_attr($class) . '" href="' . esc_url(amichai_whatsapp_url()) . '" target="_blank" rel="noopener noreferrer">';
    echo '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.4a10 10 0 0 0 4.65 1.18h.01c5.46 0 9.89-4.4 9.89-9.83C21.94 6.4 17.5 2 12.04 2zm5.76 14.05c-.24.68-1.4 1.3-1.94 1.38-.5.07-1.12.1-1.81-.11-.41-.13-.95-.31-1.63-.6-2.87-1.24-4.74-4.13-4.88-4.32-.14-.19-1.16-1.54-1.16-2.94s.73-2.08 1-2.37c.24-.28.64-.41 1.02-.41.12 0 .23 0 .33.01.3.01.44.03.64.49.24.58.82 2 .89 2.15.07.14.12.31.02.5-.09.19-.14.31-.28.48-.14.16-.29.37-.42.49-.14.14-.28.29-.12.55.16.26.7 1.15 1.5 1.86 1.03.92 1.9 1.2 2.17 1.34.26.13.42.11.57-.07.16-.19.66-.77.84-1.03.18-.26.35-.22.58-.13.24.09 1.49.7 1.74.83.26.13.43.19.49.3.07.11.07.64-.17 1.32z"/></svg>';
    echo 'שלחו בוואטסאפ</a>';
}

function amichai_intro_cta(): void {
    ?>
    <aside class="am-intro-cta" aria-label="שיחת היכרות">
      <p>שיחת היכרות, בלי התחייבות</p>
      <div class="am-intro-cta-actions">
        <a class="am-btn am-btn-primary" href="tel:054-2372417">054-2372417</a>
        <a class="am-intro-link" href="<?php echo esc_url(home_url('/צור-קשר/')); ?>">לתיאום שיחת היכרות</a>
      </div>
    </aside>
    <?php
}

add_filter('wp_get_loading_optimization_attributes', function (array $attrs, string $tag_name, array $attr): array {
    $class = (string) ($attr['class'] ?? '');
    if ($tag_name === 'img' && str_contains($class, 'am-inline-photo')) {
        unset($attrs['loading']);
        $attrs['decoding'] = 'async';
        $attrs['fetchpriority'] = 'high';
    }
    return $attrs;
}, 10, 3);

function amichai_asset(string $path): string {
    return get_template_directory_uri() . '/' . ltrim($path, '/');
}

function amichai_posted_on(): string {
    return get_the_date('j בF Y');
}

function amichai_card_category(): string {
    $cats = get_the_category() ?: [];
    foreach ($cats as $cat) {
        if ($cat->name !== 'מאמרים') {
            return $cat->name;
        }
    }
    return '';
}

function amichai_post_card(): void {
    $cat = amichai_card_category();
    ?>
    <article <?php post_class('am-card'); ?>>
      <a class="am-card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php amichai_card_image(get_post()); ?>
      </a>
      <div class="am-card-body">
        <p class="am-meta"><?php
          if ($cat !== '') {
              echo esc_html($cat) . ' · ';
          }
          ?><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j.n.Y')); ?></time></p>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
      </div>
    </article>
    <?php
}

function amichai_story_index(int $exclude_id): void {
    $term = get_term_by('name', 'סיפורי משפחות', 'category');
    $posts = [];
    if ($term && !is_wp_error($term)) {
        $posts = get_posts([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 40,
            'category' => (int) $term->term_id,
            'post__not_in' => [$exclude_id],
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
    }
    $first = [
        'המלצה' => 'המלצה מערן ושרון',
        'מכתב-תודה-לעמיחי-טלי-וחנן' => 'מכתב תודה – טלי וחנן, משפחת בר-און',
        'המלצה-מפנינה-שלומיוק-מנהלת-הספרייה' => 'המלצה מפנינה שלומיוק, הספרייה הציבורית אזור',
    ];
    $by_slug = [];
    foreach ($posts as $post) {
        $by_slug[rawurldecode((string) $post->post_name)] = $post;
    }
    echo '<ul class="am-related am-story-index">';
    $shown = [];
    foreach ($first as $slug => $label) {
        if (!isset($by_slug[$slug])) {
            continue;
        }
        $post = $by_slug[$slug];
        $shown[$slug] = true;
        echo '<li><a href="' . esc_url(get_permalink($post)) . '">' . esc_html($label) . '</a></li>';
    }
    foreach ($posts as $post) {
        $slug = rawurldecode((string) $post->post_name);
        if (isset($shown[$slug])) {
            continue;
        }
        $title = get_the_title($post);
        if ($slug === 'המלצה-הוד-השרון' && $title === 'המלצה') {
            $title = 'המלצה מהוד השרון';
        }
        echo '<li><a href="' . esc_url(get_permalink($post)) . '">' . esc_html($title) . '</a></li>';
    }
    echo '</ul>';
}

add_filter('get_the_archive_title', function (string $title): string {
    if (is_category()) {
        return single_cat_title('', false);
    }
    return $title;
});
