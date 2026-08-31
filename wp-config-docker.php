<?php
/**
 * Extra WordPress configuration for the Ahavat HaChai Docker / generic host setup.
 *
 * Docker: this file is mounted at /var/www/html/wp-config-extra.php for reference.
 * The official wordpress image already generates wp-config.php from env vars.
 *
 * Generic host: copy this file's defines into wp-config.php after the database block,
 * or require it from wp-config.php:
 *
 *   require __DIR__ . '/wp-config-docker.php';
 */

if (!defined('ABSPATH')) {
    // Allow this file to be required from wp-config.php.
}

if (!defined('WP_HOME') && getenv('WORDPRESS_URL')) {
    define('WP_HOME', rtrim(getenv('WORDPRESS_URL'), '/'));
    define('WP_SITEURL', rtrim(getenv('WORDPRESS_URL'), '/'));
}

if (!defined('AHAVAT_GTM_ID')) {
    define('AHAVAT_GTM_ID', getenv('AHAVAT_GTM_ID') ?: '');
}

if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', false);
}

define('AUTOMATIC_UPDATER_DISABLED', false);
define('DISALLOW_FILE_EDIT', true);
