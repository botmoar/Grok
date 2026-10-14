<?php
/**
 * Idempotent content seed. Run via WP-CLI: wp eval-file docker/seed.php
 */

if (!defined('ABSPATH')) {
    fwrite(STDERR, "Run this file with wp eval-file.\n");
    exit(1);
}

global $wpdb;

// The JSON is the source of truth for every page and post body, so the seed keeps no revisions
// and clears old ones: they can hold text that was deliberately removed from the site.
add_filter('wp_revisions_to_keep', '__return_zero');
$revision_ids = $wpdb->get_col(
    "SELECT r.ID FROM {$wpdb->posts} r JOIN {$wpdb->posts} p ON p.ID = r.post_parent
     WHERE r.post_type = 'revision' AND p.post_type IN ('page', 'post')"
);
foreach ($revision_ids as $revision_id) {
    wp_delete_post_revision((int) $revision_id);
}

$data_dir = WP_CONTENT_DIR . '/amichai-data';
$posts = json_decode((string) file_get_contents($data_dir . '/posts.json'), true);
$pages = json_decode((string) file_get_contents($data_dir . '/pages.json'), true);
if (!is_array($posts) || !is_array($pages)) {
    fwrite(STDERR, "Could not read seed JSON.\n");
    exit(1);
}

update_option('blogname', 'עמיחי מרקס');
update_option('blogdescription', 'ייעוץ לכלכלת המשפחה וביטחון פיננסי');
update_option('timezone_string', 'Asia/Jerusalem');
update_option('date_format', 'j בF Y');
update_option('time_format', 'H:i');
update_option('start_of_week', '0');
update_option('permalink_structure', '/%postname%/');
// Only the production host may be indexed. The seed never flips blog_public on for it; that is a launch step.
if (wp_parse_url(home_url(), PHP_URL_HOST) !== 'amichai-marx.co.il') {
    update_option('blog_public', '0');
}
update_option('default_comment_status', 'closed');
update_option('default_ping_status', 'closed');
update_option('WPLANG', 'he_IL');
update_option('posts_per_page', '9');

if (function_exists('switch_theme')) {
    switch_theme('amichai-marx');
}
set_theme_mod('amichai_ga4_id', 'G-5SR358LG0Z');
set_theme_mod('amichai_ga4_enabled', false);

$redirect_file = '/redirects.json';
if (!is_readable($redirect_file)) {
    $redirect_file = $data_dir . '/redirects.json';
}
$redirect_rules = json_decode((string) @file_get_contents($redirect_file), true);
if (is_array($redirect_rules)) {
    foreach ($redirect_rules as $rule) {
        if (empty($rule['from'])) {
            continue;
        }
        $slug = trim((string) $rule['from'], '/');
        $old_posts = get_posts([
            'name' => sanitize_title($slug),
            'post_type' => 'post',
            'post_status' => 'any',
            'posts_per_page' => 5,
        ]);
        foreach ($old_posts as $old_post) {
            wp_delete_post((int) $old_post->ID, true);
        }
    }
}

foreach (['hello-world' => 'post', 'sample-page' => 'page'] as $slug => $type) {
    $old = get_posts([
        'name' => $slug,
        'post_type' => $type,
        'post_status' => 'any',
        'posts_per_page' => 1,
    ]);
    if ($old) {
        wp_delete_post($old[0]->ID, true);
    }
}

function amichai_seed_find(string $slug, string $type): int {
    global $wpdb;
    return (int) $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s AND post_status NOT IN ('trash', 'auto-draft', 'inherit') ORDER BY ID ASC LIMIT 1",
        sanitize_title($slug),
        $type
    ));
}

// WordPress installs an English "Privacy Policy" draft on privacy-policy; earlier seeds left numbered copies.
$privacy_rows = $wpdb->get_results($wpdb->prepare(
    "SELECT ID, post_name, post_title FROM {$wpdb->posts} WHERE post_type = 'page' AND post_name LIKE %s",
    $wpdb->esc_like('privacy-policy') . '%'
));
foreach ($privacy_rows as $row) {
    if ($row->post_title === 'Privacy Policy' || preg_match('/^privacy-policy-\d+$/', $row->post_name)) {
        wp_delete_post((int) $row->ID, true);
    }
}

$category_slugs = [
    'ייעוץ כלכלי' => 'ייעוץ-כלכלי',
    'כללי' => 'כללי',
    'מאמרים' => 'מאמרים',
    'סיפורי משפחות' => 'סיפורי-משפחות',
    'שירותים שלנו' => 'שירותים-שלנו',
    'משכנתאות' => 'משכנתאות',
];
$category_ids = [];
foreach ($category_slugs as $name => $slug) {
    $existing = get_term_by('slug', sanitize_title($slug), 'category');
    if ($existing && !is_wp_error($existing)) {
        $category_ids[$name] = (int) $existing->term_id;
        continue;
    }
    $created = wp_insert_term($name, 'category', ['slug' => $slug]);
    if (is_wp_error($created)) {
        $again = get_term_by('name', $name, 'category');
        if ($again) {
            $category_ids[$name] = (int) $again->term_id;
            continue;
        }
        fwrite(STDERR, "category {$name}: {$created->get_error_message()}\n");
        continue;
    }
    $category_ids[$name] = (int) $created['term_id'];
}

function amichai_seed_upsert(array $row, string $type): int {
    $found_id = amichai_seed_find((string) $row['slug'], $type);
    $postarr = [
        'post_title' => $row['title'],
        'post_name' => $row['slug'],
        'post_content' => $row['content'] ?? '',
        'post_excerpt' => $row['excerpt'] ?? '',
        'post_status' => 'publish',
        'post_type' => $type,
        'comment_status' => 'closed',
        'ping_status' => 'closed',
    ];
    if (!empty($row['date'])) {
        $postarr['post_date'] = $row['date'];
        $postarr['post_date_gmt'] = get_gmt_from_date($row['date']);
    }
    if ($found_id > 0) {
        $postarr['ID'] = $found_id;
        $id = wp_update_post(wp_slash($postarr), true);
    } else {
        $id = wp_insert_post(wp_slash($postarr), true);
    }
    if (is_wp_error($id)) {
        fwrite(STDERR, $row['slug'] . ': ' . $id->get_error_message() . "\n");
        return 0;
    }
    if (!empty($row['template'])) {
        update_post_meta($id, '_wp_page_template', $row['template']);
    } else {
        delete_post_meta($id, '_wp_page_template');
    }
    if (!empty($row['seo_title'])) {
        update_post_meta($id, '_amichai_seo_title', $row['seo_title']);
    }
    if (!empty($row['meta_desc'])) {
        update_post_meta($id, '_amichai_meta_desc', $row['meta_desc']);
    }
    foreach (['faq' => '_amichai_faq', 'related' => '_amichai_related'] as $field => $meta_key) {
        if (!empty($row[$field]) && is_array($row[$field])) {
            update_post_meta($id, $meta_key, wp_slash(wp_json_encode($row[$field], JSON_UNESCAPED_UNICODE)));
        } else {
            delete_post_meta($id, $meta_key);
        }
    }
    return (int) $id;
}

function amichai_seed_encode_url(string $url): string {
    $parts = wp_parse_url($url);
    if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host']) || empty($parts['path'])) {
        return $url;
    }
    $segments = array_map(
        static function (string $segment): string {
            return rawurlencode(rawurldecode($segment));
        },
        explode('/', $parts['path'])
    );
    $path = implode('/', $segments);
    $rebuilt = $parts['scheme'] . '://' . $parts['host'] . $path;
    if (!empty($parts['query'])) {
        $rebuilt .= '?' . $parts['query'];
    }
    return $rebuilt;
}

function amichai_seed_thumbnail(int $post_id, string $url, string $title): bool {
    $url = trim($url);
    if ($post_id <= 0 || $url === '') {
        return false;
    }
    $encoded = amichai_seed_encode_url($url);
    add_filter('http_headers_useragent', static function (): string {
        return 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36';
    });
    $current = (int) get_post_thumbnail_id($post_id);
    if ($current > 0 && get_post_meta($current, '_amichai_source_url', true) === $url) {
        return true;
    }
    $found = get_posts([
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'meta_key' => '_amichai_source_url',
        'meta_value' => $url,
        'posts_per_page' => 1,
        'fields' => 'ids',
    ]);
    if ($found) {
        set_post_thumbnail($post_id, (int) $found[0]);
        return true;
    }
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attachment_id = media_sideload_image($encoded, $post_id, $title, 'id');
    if (is_wp_error($attachment_id)) {
        fwrite(STDERR, "thumb {$post_id}: {$attachment_id->get_error_message()}\n");
        return false;
    }
    update_post_meta((int) $attachment_id, '_amichai_source_url', $url);
    set_post_thumbnail($post_id, (int) $attachment_id);
    return true;
}

$page_ids = [];
foreach ($pages as $page) {
    $id = amichai_seed_upsert($page, 'page');
    $page_ids[$page['slug']] = $id;
    echo "page {$page['slug']} => {$id}\n";
}

$featured_map = json_decode((string) file_get_contents($data_dir . '/blog-featured-map.json'), true);
if (!is_array($featured_map)) {
    $featured_map = [];
}
$thumbs = 0;
foreach ($posts as $post) {
    $id = amichai_seed_upsert($post, 'post');
    if (!$id) {
        continue;
    }
    $cats = [];
    foreach ($post['categories'] ?? [] as $name) {
        if (isset($category_ids[$name])) {
            $cats[] = $category_ids[$name];
        }
    }
    if ($cats) {
        wp_set_post_categories($id, $cats, false);
    }
    $image = '';
    if (!empty($post['featured_image']) && is_string($post['featured_image'])) {
        $image = $post['featured_image'];
    } elseif (!empty($featured_map[$post['slug']]['image'])) {
        $image = (string) $featured_map[$post['slug']]['image'];
    }
    if ($image !== '' && amichai_seed_thumbnail($id, $image, (string) ($post['title'] ?? ''))) {
        $thumbs++;
    }
}
echo 'posts seeded: ' . count($posts) . "\n";
echo 'thumbnails set: ' . $thumbs . "\n";

if (!empty($page_ids['עמוד-הבית'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $page_ids['עמוד-הבית']);
}
if (!empty($page_ids['privacy-policy'])) {
    update_option('wp_page_for_privacy_policy', $page_ids['privacy-policy']);
}
if (!empty($category_ids['מאמרים'])) {
    update_option('default_category', $category_ids['מאמרים']);
}

$icon_file = get_template_directory() . '/assets/images/icon-512.png';
$icon_id = (int) get_option('site_icon');
if ($icon_id <= 0 || get_post_meta($icon_id, '_amichai_source_url', true) !== 'theme:icon-512.png') {
    if (is_readable($icon_file)) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $upload = wp_upload_bits('amichai-marx-site-icon.png', null, (string) file_get_contents($icon_file));
        if (empty($upload['error'])) {
            $icon_id = wp_insert_attachment([
                'post_mime_type' => 'image/png',
                'post_title' => 'סמל האתר',
                'post_status' => 'inherit',
            ], $upload['file']);
            wp_update_attachment_metadata($icon_id, wp_generate_attachment_metadata($icon_id, $upload['file']));
            update_post_meta($icon_id, '_amichai_source_url', 'theme:icon-512.png');
            update_option('site_icon', $icon_id);
        }
    }
}

$menu_name = 'ראשי';
$menu = wp_get_nav_menu_object($menu_name);
$menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu($menu_name);
$existing_items = wp_get_nav_menu_items($menu_id);
if (is_array($existing_items)) {
    foreach ($existing_items as $item) {
        wp_delete_post($item->ID, true);
    }
}

// Rebuilt on every seed. Staging needs one seed run after deploy so this menu replaces the old five links.
$order = 0;
$resolve_id = static function (array $item) use ($page_ids): int {
    $type = (string) ($item['type'] ?? '');
    $slug = (string) ($item['slug'] ?? '');
    if ($type === 'page') {
        return (int) ($page_ids[$slug] ?? 0);
    }
    if ($type !== 'post' || $slug === '') {
        return 0;
    }
    $found = get_posts([
        'name' => sanitize_title($slug),
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ]);
    return $found ? (int) $found[0]->ID : 0;
};
$add = static function (array $item, int $parent = 0) use ($menu_id, &$order, $resolve_id, &$add): void {
    $order++;
    $type = (string) ($item['type'] ?? '');
    $args = [
        'menu-item-title' => (string) $item['label'],
        'menu-item-status' => 'publish',
        'menu-item-position' => $order,
        'menu-item-parent-id' => $parent,
        'menu-item-classes' => (string) ($item['class'] ?? ''),
    ];
    if ($type === 'custom') {
        $args['menu-item-type'] = 'custom';
        $args['menu-item-url'] = home_url((string) ($item['path'] ?? '/'));
    } else {
        $object_id = $resolve_id($item);
        if ($object_id <= 0) {
            fwrite(STDERR, 'menu skip missing ' . ($item['slug'] ?? $item['label']) . "\n");
            $order--;
            return;
        }
        $args['menu-item-type'] = 'post_type';
        $args['menu-item-object-id'] = $object_id;
        $args['menu-item-object'] = $type === 'page' ? 'page' : 'post';
    }
    $item_id = (int) wp_update_nav_menu_item($menu_id, 0, $args);
    foreach ($item['children'] ?? [] as $child) {
        $add($child, $item_id);
    }
};
if (function_exists('amichai_primary_menu_tree')) {
    foreach (amichai_primary_menu_tree() as $item) {
        $add($item, 0);
    }
}
echo "menu items: {$order}\n";
$locations = get_theme_mod('nav_menu_locations');
if (!is_array($locations)) {
    $locations = [];
}
$locations['primary'] = $menu_id;
set_theme_mod('nav_menu_locations', $locations);

flush_rewrite_rules(false);
update_option('amichai_seed_version', '1');

$about = get_posts([
    'name' => sanitize_title('אודות'),
    'post_type' => 'page',
    'posts_per_page' => 1,
]);
if ($about) {
    echo 'about permalink: ' . get_permalink($about[0]) . "\n";
}
echo "seed ok\n";
