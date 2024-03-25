<?php

/**
 * Enqueue scripts and styles.
 */
function wp_starter_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');
    // enqueue jquery
    wp_enqueue_script('jquery');
    // Runtime must be loaded first
    wp_enqueue_script('wp_starter-runtime', get_template_directory_uri() . '/dist/runtime.js', array(), $theme_version, true);

    // Vendor chunk (Common libraries and modules)
    wp_enqueue_script('wp_starter-vendor', get_template_directory_uri() . '/dist/npm..pnpm.js', array('wp_starter-runtime'), $theme_version, true);

    // Main app script
    wp_enqueue_script('wp_starter-app', get_template_directory_uri() . '/dist/app.js', array('wp_starter-runtime', 'wp_starter-vendor'), $theme_version, true);

    // Global styles
    wp_enqueue_style('wp_starter-global-style', get_template_directory_uri() . '/dist/global_style.css', array(), $theme_version);
}
add_action('wp_enqueue_scripts', 'wp_starter_enqueue_assets');
