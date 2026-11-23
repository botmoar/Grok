<?php
/**
 * Plugin Name: Amichai preview, redirects, robots
 * Description: Noindex while blog_public is off, 301 map, robots.txt.
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

// Indexing follows one switch only: Settings > Reading > "Discourage search engines" (blog_public).
function amichai_is_live(): bool {
    return (string) get_option('blog_public') === '1';
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

add_filter('wp_sitemaps_enabled', static function ($enabled) {
    return defined('WPSEO_VERSION') ? false : true;
});

add_filter('robots_txt', function (string $output, $public): string {
    if (amichai_is_live() && defined('WPSEO_VERSION')) {
        return $output;
    }
    $lines = ["User-agent: *"];
    if (!amichai_is_live()) {
        $lines[] = 'Disallow: /';
        $lines[] = '';
        $lines[] = '# Preview build. Indexing turns on with blog_public=1.';
        return implode("\n", $lines) . "\n";
    }
    $lines[] = 'Disallow: /wp-admin/';
    $lines[] = 'Allow: /wp-admin/admin-ajax.php';
    $lines[] = 'Disallow: /wp-login.php';
    $lines[] = 'Disallow: /?s=';
    $lines[] = '';
    $sitemap = defined('WPSEO_VERSION') ? home_url('/sitemap_index.xml') : home_url('/wp-sitemap.xml');
    $lines[] = 'Sitemap: ' . $sitemap;
    return implode("\n", $lines) . "\n";
}, 99, 2);

function amichai_redirect_rules(): array {
    static $map = null;
    if ($map !== null) {
        return $map;
    }
    $map = [];
    foreach ([
        '/redirects.json',
        WP_CONTENT_DIR . '/amichai-data/redirects.json',
        WP_CONTENT_DIR . '/amichai-data/mortgage-redirects.json',
    ] as $file) {
        if (!is_readable($file)) {
            continue;
        }
        $data = json_decode((string) file_get_contents($file), true);
        if (!is_array($data)) {
            continue;
        }
        foreach ($data as $rule) {
            if (empty($rule['from']) || empty($rule['to'])) {
                continue;
            }
            $from = amichai_normalize_redirect_path((string) $rule['from']);
            $to = (string) $rule['to'];
            if ($from === '/' || $from === amichai_normalize_redirect_path($to)) {
                continue; // never intercept the homepage; skip identity rules
            }
            $map[$from] = $to;
        }
    }
    return $map;
}

function amichai_normalize_redirect_path(string $path): string {
    $path = rawurldecode($path);
    $path = (string) (wp_parse_url($path, PHP_URL_PATH) ?? $path);
    $path = '/' . trim($path, '/');
    if ($path === '/' || $path === '') {
        return '/';
    }
    $last = basename($path);
    if (str_contains($last, '.')) {
        return $path; // sitemap_index.xml and other files
    }
    return $path . '/';
}

function amichai_canonical_legacy_path(string $path): string {
    $path = amichai_normalize_redirect_path($path);
    if ($path === '/') {
        return '/';
    }
    // Collapse embed, feed, and pagination so every old variant shares one target.
    $path = preg_replace('#/(?:embed|feed)/$#u', '/', $path) ?? $path;
    $path = preg_replace('#/page/\d+/?$#u', '/', $path) ?? $path;
    return amichai_normalize_redirect_path($path);
}

function amichai_request_path(): string {
    $uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
    return amichai_normalize_redirect_path((string) wp_parse_url($uri, PHP_URL_PATH));
}

function amichai_redirect_target_for_path(string $path): string {
    $map = amichai_redirect_rules();
    $exact = amichai_normalize_redirect_path($path);
    if ($exact !== '/' && isset($map[$exact])) {
        return $map[$exact];
    }
    $canon = amichai_canonical_legacy_path($path);
    if ($canon !== '/' && isset($map[$canon])) {
        return $map[$canon];
    }
    // Identity pages still have working /feed/ RSS; send those (and /embed/) to the page itself.
    if ($canon !== '/' && $canon !== $exact && preg_match('#/(?:embed|feed)/$#u', $exact)) {
        return $canon;
    }
    return '';
}

// Some category URLs share a path with a redirected legacy post; link straight to the final page.
add_filter('term_link', function (string $url): string {
    $target = amichai_redirect_target_for_path((string) wp_parse_url($url, PHP_URL_PATH));
    return $target !== '' ? home_url($target) : $url;
});

add_action('init', function (): void {
    if (is_admin() || (function_exists('wp_doing_ajax') && wp_doing_ajax()) || (function_exists('wp_doing_cron') && wp_doing_cron())) {
        return;
    }
    $path = amichai_request_path();
    if ($path === '/') {
        return; // uPress also 308s the old homepage here; no reliable signal to tell it apart
    }
    $target = amichai_redirect_target_for_path($path);
    if ($target === '') {
        return;
    }
    if (amichai_normalize_redirect_path($target) === $path) {
        return;
    }
    wp_redirect(home_url($target), 301);
    exit;
}, 0); // init: beat Yoast author-archive redirects to the homepage

// Soft fallback for unmapped 404s: parent of embed/feed/pagination if we stripped one,
// otherwise mortgage-keyword (or old-domain referrer) paths go to the hub, never the homepage.
add_action('template_redirect', function (): void {
    if (is_admin() || !is_404()) {
        return;
    }
    $path = amichai_request_path();
    if ($path === '/') {
        return;
    }
    $target = amichai_redirect_target_for_path($path);
    if ($target === '') {
        $canon = amichai_canonical_legacy_path($path);
        if ($canon !== '/' && $canon !== $path) {
            $target = $canon;
        }
    }
    if ($target === '') {
        $haystack = $path . ' ' . rawurldecode($path);
        $is_mortgage = (bool) preg_match('/משכנת|מיחזור|מחזור|הלוואה|mortgage/iu', $haystack);
        $ref = (string) wp_get_referer();
        $from_old = (bool) preg_match('#^https?://(www\.)?amichaimortgage\.co\.il(:\d+)?(/|$)#i', $ref);
        if ($is_mortgage || $from_old) {
            $target = '/דיור-ומשכנתאות/';
        }
    }
    if ($target === '' || amichai_normalize_redirect_path($target) === $path) {
        return;
    }
    wp_redirect(home_url($target), 301);
    exit;
}, 99);

// Hardening: no author archives or user listing (they expose login names), no XML-RPC.
add_action('init', function (): void {
    if (is_admin() || (function_exists('wp_doing_ajax') && wp_doing_ajax())) {
        return;
    }
    $path = amichai_request_path();
    if (isset($_GET['author']) || preg_match('#^/author/#', $path)) {
        wp_safe_redirect(home_url('/אודות/'), 301);
        exit;
    }
}, 1);

add_filter('rest_endpoints', function (array $endpoints): array {
    if (!is_user_logged_in()) {
        unset($endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});

add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_headers', function (array $headers): array {
    unset($headers['X-Pingback']);
    return $headers;
});
add_filter('wp_sitemaps_add_provider', function ($provider, string $name) {
    return $name === 'users' ? false : $provider;
}, 10, 2);
