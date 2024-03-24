<?php

// Path: inc\acf-blocks.php
if (!defined('ABSPATH')) {
    exit;
}

// TAMTAM_VERSION
if (!defined('TAMTAM_VERSION')) {
    define('TAMTAM_VERSION', '1.0.0');
}
// Block categories
add_filter('block_categories_all', function ($categories) {

    // Adding a new category.
    $categories[] = array(
        'slug'  => 'kd',
        'title' => 'KD Blocks',
        // icon the logo
        'icon'  => 'kd-logo',
        'order' => 1,
    );

    return $categories;
});

// Block Editor styles
function tamtam_editor_styles()
{
    wp_enqueue_style('tamtam-editor-styles', get_template_directory_uri() . '/dist/admin/editor.css', false, TAMTAM_VERSION, 'all');
}
add_action('enqueue_block_editor_assets', 'tamtam_editor_styles');


// Helper function to get asset path from manifest file
function tamtam_get_asset_path($filename)
{
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);
        // Construct the key as it appears in the manifest. Adjust if your structure is different.
        $key = 'src/blocks-assets/scripts/' . $filename;
        if (isset($manifest[$key])) {
            $file_info = $manifest[$key];
            $file_path = get_template_directory_uri() . '/dist/' . $file_info['file'];
            return $file_path;
        }
    }
    return null; // Fallback in case the file is not found in the manifest
}


function tamtam_acf_init_block_types()
{
    if (function_exists('acf_register_block_type')) {
        // Hero block
        acf_register_block_type(
            array(
                'name'              => 'hero',
                'title'             => __('Hero'),
                'description'       => __('A block to display hero.'),
                'render_template'   => 'block-templates/hero-block.php',
                'category'          => 'kd',
                'icon'              => 'kd-logo',
                'keywords'          => array('hero', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),

            )
        );

        // Our Partners block
        acf_register_block_type(
            array(
                'name'              => 'our-partners',
                'title'             => __('Our Partners'),
                'description'       => __('A block to display our partners.'),
                'render_template'   => 'block-templates/our-partners-block.php',
                'category'          => 'kd',
                'icon'              => 'kd-logo',
                'keywords'          => array('our partners', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),

            )
        );
    }
}
add_action('acf/init', 'tamtam_acf_init_block_types');
