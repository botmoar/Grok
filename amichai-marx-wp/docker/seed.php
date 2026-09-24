<?php
/**
 * Idempotent content seed. Run via WP-CLI: wp eval-file docker/seed.php
 */

if (!defined('ABSPATH')) {
    fwrite(STDERR, "Run this file with wp eval-file.\n");
    exit(1);
}

$data_dir = WP_CONTENT_DIR . '/amichai-data';
$posts = json_decode((string) file_get_contents($data_dir . '/posts.json'), true);
$pages = json_decode((string) file_get_contents($data_dir . '/pages.json'), true);
if (!is_array($posts) || !is_array($pages)) {
    fwrite(STDERR, "Could not read seed JSON.\n");
    exit(1);
}

$live = defined('AMICHAI_GO_LIVE') && AMICHAI_GO_LIVE;
update_option('blogname', 'עמיחי מרקס');
update_option('blogdescription', 'ייעוץ לכלכלת המשפחה וביטחון פיננסי');
update_option('timezone_string', 'Asia/Jerusalem');
update_option('date_format', 'j בF Y');
update_option('time_format', 'H:i');
update_option('start_of_week', '0');
update_option('permalink_structure', '/%postname%/');
update_option('blog_public', $live ? '1' : '0');
update_option('default_comment_status', 'closed');
update_option('default_ping_status', 'closed');
update_option('WPLANG', 'he_IL');
update_option('posts_per_page', '9');

if (function_exists('switch_theme')) {
    switch_theme('amichai-marx');
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

$english_privacy = get_posts([
    'name' => 'privacy-policy',
    'post_type' => 'page',
    'post_status' => 'any',
    'posts_per_page' => 1,
]);
if ($english_privacy && $english_privacy[0]->post_title === 'Privacy Policy') {
    wp_delete_post((int) $english_privacy[0]->ID, true);
}
$privacy_dup = get_posts([
    'name' => 'privacy-policy-2',
    'post_type' => 'page',
    'post_status' => 'any',
    'posts_per_page' => 1,
]);
if ($privacy_dup) {
    $canonical = get_posts([
        'name' => 'privacy-policy',
        'post_type' => 'page',
        'post_status' => 'any',
        'posts_per_page' => 1,
    ]);
    if ($canonical) {
        wp_delete_post((int) $privacy_dup[0]->ID, true);
    } else {
        wp_update_post([
            'ID' => (int) $privacy_dup[0]->ID,
            'post_name' => 'privacy-policy',
        ]);
    }
}

$category_slugs = [
    'ייעוץ כלכלי' => 'ייעוץ-כלכלי',
    'כללי' => 'כללי',
    'מאמרים' => 'מאמרים',
    'סיפורי משפחות' => 'סיפורי-משפחות',
    'שירותים שלנו' => 'שירותים-שלנו',
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
    $lookup = sanitize_title($row['slug']);
    $found = get_posts([
        'name' => $lookup,
        'post_type' => $type,
        'post_status' => 'any',
        'posts_per_page' => 1,
    ]);
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
    if ($found) {
        $postarr['ID'] = $found[0]->ID;
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
    return (int) $id;
}

$page_ids = [];
foreach ($pages as $page) {
    $id = amichai_seed_upsert($page, 'page');
    $page_ids[$page['slug']] = $id;
    echo "page {$page['slug']} => {$id}\n";
}

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
}
echo 'posts seeded: ' . count($posts) . "\n";

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

$menu_name = 'ראשי';
$menu = wp_get_nav_menu_object($menu_name);
$menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu($menu_name);
$existing_items = wp_get_nav_menu_items($menu_id);
if (is_array($existing_items)) {
    foreach ($existing_items as $item) {
        wp_delete_post($item->ID, true);
    }
}

$menu_posts = [
    'ייעוץ-כלכלי' => 'ייעוץ כלכלי',
    'כלכלת-משפחה' => 'כלכלת משפחה',
];
$order = 0;
$add = function (string $title, int $object_id, string $object) use ($menu_id, &$order): void {
    $order++;
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => $title,
        'menu-item-object-id' => $object_id,
        'menu-item-object' => $object,
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish',
        'menu-item-position' => $order,
    ]);
};
if (!empty($page_ids['עמוד-הבית'])) {
    $add('עמוד הבית', $page_ids['עמוד-הבית'], 'page');
}
if (!empty($page_ids['אודות'])) {
    $add('אודות', $page_ids['אודות'], 'page');
}
foreach ($menu_posts as $slug => $title) {
    $found = get_posts([
        'name' => sanitize_title($slug),
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ]);
    if ($found) {
        $add($title, (int) $found[0]->ID, 'post');
    }
}
if (!empty($page_ids['צור-קשר'])) {
    $add('צור קשר', $page_ids['צור-קשר'], 'page');
}
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
