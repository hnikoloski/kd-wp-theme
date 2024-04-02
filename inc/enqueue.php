<?php

/**
 * Enqueue scripts and styles.
 */
function wp_starter_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');

    $dev_mode = defined('WP_DEBUG') && WP_DEBUG; // Adjust based on your dev environment detection method

    $script_base_url = $dev_mode ? 'http://localhost:3000/' : get_template_directory_uri() . '/dist/assets/';

    wp_enqueue_script('wp_starter-app', $script_base_url . 'app.js', array('jquery'), $theme_version, true);

    // Main app script
    // wp_enqueue_script('wp_starter-app', get_template_directory_uri() . '/dist/assets/app.js', array('jquery'), $theme_version, true);


    // Global styles
    // wp_enqueue_style('wp_starter-global-style', get_template_directory_uri() . '/dist/assets/global_style.css', array(), $theme_version);
    wp_enqueue_style('wp_starter-global-style', $script_base_url . 'global_style.css', array(), $theme_version);
}
add_action('wp_enqueue_scripts', 'wp_starter_enqueue_assets');

// add type="module" to script tag
function add_type_attribute($tag, $handle, $src)
{
    if ('wp_starter-app' !== $handle) {
        return $tag;
    }
    $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute', 10, 3);
