<?php
/**
 * Idempotent content import for Ahavat HaChai.
 * Run: wp eval-file /seed/import.php
 */

if (!defined('ABSPATH')) {
    fwrite(STDERR, "Run via WP-CLI: wp eval-file /seed/import.php\n");
    exit(1);
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$json_path = '/seed/content.json';
if (!is_readable($json_path)) {
    $json_path = dirname(__DIR__) . '/seed/content.json';
}
$data = json_decode(file_get_contents($json_path), true);
if (!$data) {
    WP_CLI::error('Cannot read seed/content.json');
}

$theme_images = get_stylesheet_directory() . '/assets/images';
$media_cache = [];

function ahavat_import_find_by_name($name, $type) {
    $found = get_posts([
        'name' => $name,
        'post_type' => $type,
        'post_status' => 'any',
        'numberposts' => 1,
        'suppress_filters' => true,
    ]);
    if ($found) {
        return $found[0];
    }
    global $wpdb;
    $id = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s LIMIT 1",
        $name,
        $type
    ));
    return $id ? get_post($id) : null;
}

function ahavat_import_upsert_post($args) {
    $existing = null;
    if (!empty($args['post_name']) && !empty($args['post_type'])) {
        $existing = ahavat_import_find_by_name($args['post_name'], $args['post_type']);
        if (!$existing) {
            $sanitized = sanitize_title($args['post_name']);
            if ($sanitized !== $args['post_name']) {
                $existing = ahavat_import_find_by_name($sanitized, $args['post_type']);
            }
        }
    }
    if ($existing) {
        $args['ID'] = $existing->ID;
        wp_update_post(wp_slash($args));
        $id = (int) $existing->ID;
    } else {
        $id = (int) wp_insert_post(wp_slash($args), true);
        if (is_wp_error($id)) {
            return $id;
        }
    }
    if (!empty($args['post_name'])) {
        global $wpdb;
        $wpdb->update($wpdb->posts, ['post_name' => $args['post_name']], ['ID' => $id]);
        clean_post_cache($id);
    }
    return $id;
}

function ahavat_import_media($filename, $parent = 0) {
    global $media_cache, $theme_images;
    if (!$filename) {
        return 0;
    }
    if (isset($media_cache[$filename])) {
        return $media_cache[$filename];
    }
    $path = $theme_images . '/' . $filename;
    if (!file_exists($path)) {
        return 0;
    }
    $existing = get_posts([
        'post_type' => 'attachment',
        'meta_key' => '_ahavat_src',
        'meta_value' => $filename,
        'numberposts' => 1,
        'post_status' => 'inherit',
        'suppress_filters' => true,
    ]);
    if ($existing) {
        $media_cache[$filename] = (int) $existing[0]->ID;
        return $media_cache[$filename];
    }
    $filetype = wp_check_filetype($filename);
    $upload = wp_upload_bits($filename, null, file_get_contents($path));
    if (!empty($upload['error'])) {
        return 0;
    }
    $attachment = [
        'post_mime_type' => $filetype['type'] ?: 'image/jpeg',
        'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
        'post_content' => '',
        'post_status' => 'inherit',
    ];
    $id = wp_insert_attachment($attachment, $upload['file'], $parent);
    if (is_wp_error($id) || !$id) {
        return 0;
    }
    $meta = wp_generate_attachment_metadata($id, $upload['file']);
    wp_update_attachment_metadata($id, $meta);
    update_post_meta($id, '_ahavat_src', $filename);
    $media_cache[$filename] = (int) $id;
    return (int) $id;
}

function ahavat_import_seo($id, $item) {
    $title = $item['title_tag'] ?? '';
    $desc = $item['description'] ?? '';
    $og = $item['og_image'] ?? ($item['featured'] ?? '');
    $og_title = $item['og_title'] ?? $title;
    $og_desc = $item['og_description'] ?? $desc;
    $robots = $item['robots'] ?? '';
    if ($title) {
        update_post_meta($id, '_ahavat_seo_title', $title);
    }
    if ($desc) {
        update_post_meta($id, '_ahavat_seo_description', $desc);
    }
    if ($og) {
        update_post_meta($id, '_ahavat_og_image', $og);
    }
    if ($og_title) {
        update_post_meta($id, '_ahavat_og_title', $og_title);
    }
    if ($og_desc) {
        update_post_meta($id, '_ahavat_og_description', $og_desc);
    }
    if ($robots) {
        update_post_meta($id, '_ahavat_robots', $robots);
    } else {
        delete_post_meta($id, '_ahavat_robots');
    }
}

WP_CLI::log('Seeding Ahavat HaChai content…');

$hello = get_page_by_path('hello-world', OBJECT, 'post');
if (!$hello) {
    $found = get_posts(['name' => 'hello-world', 'post_type' => 'post', 'post_status' => 'any', 'numberposts' => 1]);
    $hello = $found ? $found[0] : null;
}
if ($hello) {
    wp_delete_post($hello->ID, true);
}

update_option('blogname', 'אהבת החי');
update_option('blogdescription', 'מרכז וטרינרי');
update_option('timezone_string', 'Asia/Jerusalem');
update_option('date_format', 'd/m/Y');
update_option('time_format', 'H:i');
update_option('start_of_week', 0);
update_option('WPLANG', 'he_IL');
update_option('blog_public', '1');
update_option('permalink_structure', '/articles/%postname%/');
flush_rewrite_rules(false);

$templates = [
    'our-team' => 'page-our-team.php',
    'our-clinic' => 'page-our-clinic.php',
    'grooming' => 'page-grooming.php',
    'hshyrvtym-shlnv' => 'page-hshyrvtym-shlnv.php',
    'rpvt-khyvt-qzvtyvt' => 'page-rpvt-khyvt-qzvtyvt.php',
    'alternative-treatment' => 'page-coming-soon.php',
    'dental-treatment' => 'page-coming-soon.php',
    'fqa' => 'page-fqa.php',
    'mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym' => 'page-mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym.php',
    'search' => 'page-search.php',
];

$page_ids = [];
foreach ($data['pages'] as $key => $page) {
    $slug = $page['slug'] === '' ? 'home' : $page['slug'];
    $is_front = ($key === 'home' || $page['slug'] === '');
    $post_name = $is_front ? 'home' : $page['slug'];
    $id = ahavat_import_upsert_post([
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_title' => $page['title'],
        'post_name' => $post_name,
        'post_content' => '',
    ]);
    if (is_wp_error($id) || !$id) {
        WP_CLI::warning("Failed page {$post_name}");
        continue;
    }
    $page_ids[$key] = $id;
    if (!$is_front && isset($templates[$page['slug']])) {
        update_post_meta($id, '_wp_page_template', $templates[$page['slug']]);
    }
    ahavat_import_seo($id, $page);
    WP_CLI::log("Page {$post_name} #{$id}");
}

if (!empty($page_ids['home'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $page_ids['home']);
    update_option('page_for_posts', 0);
}

foreach ($data['team'] as $member) {
    $id = ahavat_import_upsert_post([
        'post_type' => 'team_member',
        'post_status' => 'publish',
        'post_title' => $member['name'],
        'post_name' => $member['slug'],
        'post_content' => $member['bio'],
        'menu_order' => (int) $member['order'],
    ]);
    if (is_wp_error($id) || !$id) {
        continue;
    }
    update_post_meta($id, '_ahavat_role', $member['role']);
    update_post_meta($id, '_ahavat_role_short', $member['role_short']);
    update_post_meta($id, '_ahavat_featured', !empty($member['featured']) ? '1' : '0');
    if (!empty($member['avatar'])) {
        update_post_meta($id, '_ahavat_avatar', $member['avatar']);
    }
    if (!empty($member['photo'])) {
        $mid = ahavat_import_media($member['photo'], $id);
        if ($mid) {
            set_post_thumbnail($id, $mid);
        }
    }
    WP_CLI::log("Team {$member['slug']} #{$id}");
}

$term_order = 0;
foreach ($data['faq'] as $item) {
    $term = term_exists($item['category'], 'faq_category');
    if (!$term) {
        $term = wp_insert_term($item['category'], 'faq_category');
        $term_order++;
    }
    $term_id = is_array($term) ? (int) $term['term_id'] : 0;
    $slug = sanitize_title($item['question']);
    $id = ahavat_import_upsert_post([
        'post_type' => 'faq_item',
        'post_status' => 'publish',
        'post_title' => $item['question'],
        'post_name' => $slug,
        'post_content' => $item['answer_html'],
        'menu_order' => $term_order,
    ]);
    if (is_wp_error($id) || !$id) {
        continue;
    }
    if ($term_id) {
        wp_set_object_terms($id, [$term_id], 'faq_category');
    }
    if (!empty($item['icon'])) {
        update_post_meta($id, '_ahavat_icon', $item['icon']);
    }
}

foreach ($data['posts'] as $post) {
    $content = str_replace('{{theme_img}}', get_theme_file_uri('assets/images'), $post['content']);
    $id = ahavat_import_upsert_post([
        'post_type' => 'post',
        'post_status' => 'publish',
        'post_title' => $post['title'],
        'post_name' => $post['slug'],
        'post_content' => $content,
        'post_excerpt' => wp_strip_all_tags(mb_substr($post['description'] ?? '', 0, 180)),
    ]);
    if (is_wp_error($id) || !$id) {
        WP_CLI::warning('Failed post ' . $post['slug']);
        continue;
    }
    update_post_meta($id, '_ahavat_author', $post['author'] ?? '');
    ahavat_import_seo($id, $post);
    if (!empty($post['featured'])) {
        $mid = ahavat_import_media($post['featured'], $id);
        if ($mid) {
            set_post_thumbnail($id, $mid);
        }
    }
    WP_CLI::log("Post {$post['slug']} #{$id}");
}

$gtm = getenv('AHAVAT_GTM_ID') ?: '';
set_theme_mod('ahavat_gtm_id', $gtm);
$gsc = getenv('AHAVAT_GOOGLE_SITE_VERIFICATION') ?: 'Yi1gKMJsNN8gFXk3emgHbvyumqsm7J8L7HTXRFm6htA';
set_theme_mod('ahavat_google_site_verification', $gsc);

flush_rewrite_rules(false);

$counts = [
    'pages' => wp_count_posts('page')->publish,
    'posts' => wp_count_posts('post')->publish,
    'team' => wp_count_posts('team_member')->publish,
    'faq' => wp_count_posts('faq_item')->publish,
];
WP_CLI::success('Seed complete: ' . wp_json_encode($counts, JSON_UNESCAPED_UNICODE));
