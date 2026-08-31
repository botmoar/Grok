<?php
/**
 * Custom post types: team members and FAQ items.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_post_type('team_member', [
        'labels' => [
            'name' => 'הצוות',
            'singular_name' => 'חבר צוות',
            'add_new_item' => 'הוספת חבר צוות',
        ],
        'public' => true,
        'has_archive' => false,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields'],
        'rewrite' => ['slug' => 'team-member'],
    ]);

    register_post_type('faq_item', [
        'labels' => [
            'name' => 'שאלות ותשובות',
            'singular_name' => 'שאלה',
            'add_new_item' => 'הוספת שאלה',
        ],
        'public' => true,
        'has_archive' => false,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => ['title', 'editor', 'page-attributes', 'custom-fields'],
        'rewrite' => false,
    ]);

    register_taxonomy('faq_category', 'faq_item', [
        'labels' => [
            'name' => 'נושאי שאלות',
            'singular_name' => 'נושא',
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => false,
    ]);
});
