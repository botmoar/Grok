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

add_action('wp_enqueue_scripts', function (): void {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    wp_enqueue_style(
        'amichai-main',
        $uri . '/assets/css/main.css',
        [],
        file_exists($dir . '/assets/css/main.css') ? (string) filemtime($dir . '/assets/css/main.css') : '1.0.0'
    );
    wp_enqueue_script(
        'amichai-main',
        $uri . '/assets/js/main.js',
        [],
        file_exists($dir . '/assets/js/main.js') ? (string) filemtime($dir . '/assets/js/main.js') : '1.0.0',
        true
    );

    if (is_page_template('template-budget.php')) {
        wp_enqueue_script('amichai-budget', $uri . '/assets/js/budget.js', [], '1.0.0', true);
    }
    if (is_page_template('template-savings.php')) {
        wp_enqueue_style('amichai-savings', $uri . '/assets/css/savings.css', ['amichai-main'], '1.0.0');
        wp_enqueue_script('chartjs', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js', [], '4.4.1', true);
        wp_enqueue_script('amichai-savings', $uri . '/assets/js/savings.js', ['chartjs'], '1.0.0', true);
    }
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

add_action('admin_post_nopriv_amichai_lead', 'amichai_handle_lead');
add_action('admin_post_amichai_lead', 'amichai_handle_lead');

function amichai_handle_lead(): void {
    $back = wp_get_referer() ?: home_url('/צור-קשר/');
    $back = remove_query_arg(['lead'], $back);

    if (!isset($_POST['amichai_lead_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['amichai_lead_nonce'])), 'amichai_lead')) {
        wp_safe_redirect(add_query_arg('lead', 'err', $back));
        exit;
    }
    if (!empty($_POST['company_website'])) {
        wp_safe_redirect(add_query_arg('lead', 'ok', $back));
        exit;
    }

    $name = isset($_POST['full_name']) ? sanitize_text_field(wp_unslash($_POST['full_name'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
    $consent = !empty($_POST['privacy_ok']);

    if ($name === '' || $phone === '' || !$consent) {
        wp_safe_redirect(add_query_arg('lead', 'err', $back));
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
        wp_mail('marx@amichai-marx.co.il', 'פנייה חדשה מהאתר: ' . $name, $body);
    }

    wp_safe_redirect(add_query_arg('lead', 'ok', home_url('/צור-קשר/')));
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
        ['label' => 'עמוד הבית', 'slug' => 'עמוד-הבית', 'type' => 'page'],
        ['label' => 'אודות', 'slug' => 'אודות', 'type' => 'page'],
        ['label' => 'ייעוץ כלכלי', 'slug' => 'יועץ-לכלכלת-המשפחה', 'type' => 'post', 'children' => [
            ['label' => 'למי מיועד הייעוץ?', 'slug' => 'למי-מיועד-הייעוץ', 'type' => 'post'],
            ['label' => 'הרצאות וסדנאות', 'slug' => 'הרצאות-וסדנאות', 'type' => 'post'],
        ]],
        ['label' => 'דילמות כלכליות', 'slug' => 'דילמות-כלכליות', 'type' => 'post', 'children' => [
            ['label' => 'חיים במינוס', 'slug' => 'חיים-במינוס', 'type' => 'post'],
            ['label' => 'פנסיה', 'slug' => 'פנסיה', 'type' => 'post'],
            ['label' => 'ביטוחים', 'slug' => 'ביטוחים', 'type' => 'post'],
            ['label' => 'חסכונות', 'slug' => 'חסכונות', 'type' => 'post'],
            ['label' => 'דיור ומשכנתאות', 'slug' => 'דיור-ומשכנתאות', 'type' => 'post'],
        ]],
        ['label' => 'כלכלת משפחה', 'slug' => 'כלכלת-משפחה', 'type' => 'post', 'children' => [
            ['label' => 'סיפורי משפחות', 'slug' => 'סיפורי-משפחות', 'type' => 'post'],
        ]],
        ['label' => 'מאמרים', 'type' => 'custom', 'path' => '/מאמרים/'],
        ['label' => 'כלי עזר', 'slug' => 'כלי-עזר', 'type' => 'page', 'children' => [
            ['label' => 'מחשבון תקציב משפחתי', 'slug' => 'מחשבון-תקציב-משפחתי', 'type' => 'page'],
            ['label' => 'מחשבון חיסכון משפחתי ליעדים', 'slug' => 'מחשבון-חיסכון-משפחתי-ליעדים', 'type' => 'page'],
        ]],
        ['label' => 'מן התקשורת', 'slug' => 'מן-התקשורת', 'type' => 'page'],
        ['label' => 'צור קשר', 'slug' => 'צור-קשר', 'type' => 'page'],
    ];
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
    $class = $children ? ' class="menu-item-has-children"' : '';
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

function amichai_footer_nav(): void {
    echo '<ul>';
    foreach (amichai_primary_menu_tree() as $item) {
        if (($item['slug'] ?? '') === 'עמוד-הבית') {
            continue;
        }
        $children = $item['children'] ?? [];
        echo '<li><a href="' . esc_url(amichai_menu_item_url($item)) . '">' . esc_html((string) $item['label']) . '</a>';
        if ($children) {
            echo '<ul>';
            foreach ($children as $child) {
                echo '<li><a href="' . esc_url(amichai_menu_item_url($child)) . '">' . esc_html((string) $child['label']) . '</a></li>';
            }
            echo '</ul>';
        }
        echo '</li>';
    }
    echo '</ul>';
}

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
    return $cats ? $cats[0]->name : '';
}

function amichai_post_card(): void {
    $cat = amichai_card_category();
    ?>
    <article <?php post_class('am-card'); ?>>
      <a class="am-card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php if (has_post_thumbnail()) {
            the_post_thumbnail('medium_large', ['alt' => '']);
        } ?>
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
