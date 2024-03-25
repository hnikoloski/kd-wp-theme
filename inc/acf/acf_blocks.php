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
                'enqueue_style'     => get_template_directory_uri() . '/dist/hero_block.css',
                'enqueue_script'    => get_template_directory_uri() . '/dist/hero_block.js',

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
                'enqueue_style'     => get_template_directory_uri() . '/dist/our_partners_block.css',
                'enqueue_script'    => get_template_directory_uri() . '/dist/our_partners_block.js',


            )
        );

        // Image CTA block
        acf_register_block_type(
            array(
                'name'              => 'image-cta',
                'title'             => __('Image CTA'),
                'description'       => __('A block to display image CTA.'),
                'render_template'   => 'block-templates/image-cta-block.php',
                'category'          => 'kd',
                'icon'              => 'kd-logo',
                'keywords'          => array('image cta', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                'enqueue_style'     => get_template_directory_uri() . '/dist/image_cta_block.css',
                'enqueue_script'    => get_template_directory_uri() . '/dist/image_cta_block.js',

            )
        );
    }
}
add_action('acf/init', 'tamtam_acf_init_block_types');


add_filter('script_loader_tag', function ($tag, $handle, $src) {
    // Prefix to check in the script handles
    $prefix = 'tamtam-script';

    // Check if the handle starts with your prefix
    if (substr($handle, 0, strlen($prefix)) === $prefix) {
        // Modify the script tag to include type="module"
        $tag = '<script id="' . $handle . '" src="' . $src . '" type="module"></script>';
    }
    return $tag;
}, 10, 3);
