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
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields'],
        'rewrite' => false,
    ]);

    register_post_type('faq_item', [
        'labels' => [
            'name' => 'שאלות ותשובות',
            'singular_name' => 'שאלה',
            'add_new_item' => 'הוספת שאלה',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => false,
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
        'public' => false,
        'show_ui' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => false,
    ]);
});
