<?php
/**
 * Plugin Name: Amichai preview, redirects, robots
 * Description: Noindex until go-live, 301 map, robots.txt and sitemap switch.
 */

defined('ABSPATH') || exit;

/**
 * Browsers send percent-encoded Hebrew in uppercase. Rewrite rules store
 * WordPress slugs in lowercase, so normalize before matching.
 */
add_action('init', static function (): void {
    if (is_admin() || empty($_SERVER['REQUEST_URI']) || !is_string($_SERVER['REQUEST_URI'])) {
        return;
    }
    $_SERVER['REQUEST_URI'] = preg_replace_callback(
        '/%[0-9A-Fa-f]{2}/',
        static fn (array $m): string => strtolower($m[0]),
        $_SERVER['REQUEST_URI']
    );
}, 0);

function amichai_is_live(): bool {
    return defined('AMICHAI_GO_LIVE') && AMICHAI_GO_LIVE;
}

add_filter('wp_robots', function (array $robots): array {
    if (!amichai_is_live()) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
        unset($robots['index'], $robots['follow']);
    }
    return $robots;
}, 99);

add_action('send_headers', function (): void {
    if (!amichai_is_live() && !is_admin()) {
        header('X-Robots-Tag: noindex, nofollow', true);
    }
});

add_filter('wp_sitemaps_enabled', '__return_true');

add_filter('robots_txt', function (string $output, $public): string {
    $lines = ["User-agent: *"];
    if (!amichai_is_live()) {
        $lines[] = 'Disallow: /';
        $lines[] = '';
        $lines[] = '# Preview build. Set AMICHAI_GO_LIVE=1 and blog_public=1 before launch.';
        return implode("\n", $lines) . "\n";
    }
    $lines[] = 'Disallow: /wp-admin/';
    $lines[] = 'Allow: /wp-admin/admin-ajax.php';
    $lines[] = 'Disallow: /wp-login.php';
    $lines[] = 'Disallow: /?s=';
    $lines[] = '';
    $lines[] = 'Sitemap: ' . home_url('/wp-sitemap.xml');
    return implode("\n", $lines) . "\n";
}, 99, 2);

add_action('template_redirect', function (): void {
    if (is_admin()) {
        return;
    }
    $file = '/redirects.json';
    if (!is_readable($file)) {
        $file = WP_CONTENT_DIR . '/amichai-data/redirects.json';
    }
    if (!is_readable($file)) {
        return;
    }
    $map = json_decode((string) file_get_contents($file), true);
    if (!is_array($map)) {
        return;
    }
    $path = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
    $path = (string) wp_parse_url($path, PHP_URL_PATH);
    $path = rawurldecode($path);
    $path = '/' . trim($path, '/') . '/';
    if ($path === '//') {
        $path = '/';
    }
    foreach ($map as $rule) {
        if (empty($rule['from']) || empty($rule['to'])) {
            continue;
        }
        $from = '/' . trim((string) $rule['from'], '/') . '/';
        if ($from === $path) {
            wp_redirect(home_url($rule['to']), (int) ($rule['code'] ?? 301));
            exit;
        }
    }
}, 0);
