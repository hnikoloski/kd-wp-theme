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
        'icon'  => 'tamtam-logo',
        'order' => 1,
    );

    return $categories;
});

// Block Editor styles
function tamtam_editor_styles()
{
    wp_enqueue_style('tamtam-editor-styles', get_template_directory_uri() . '/dist/assets/editor_style.css', false, TAMTAM_VERSION, 'all');
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
                'icon'              => 'tamtam-logo',
                'keywords'          => array('hero', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/hero_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/hero_block.js',

            )
        );

        // Hero Inner block
        acf_register_block_type(
            array(
                'name'              => 'hero-inner',
                'title'             => __('Hero Inner'),
                'description'       => __('A block to display hero inner.'),
                'render_template'   => 'block-templates/hero-inner-block.php',
                'category'          => 'kd',
                'icon'              => 'tamtam-logo',
                'keywords'          => array('hero inner', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/hero_inner_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/hero_inner_block.js',
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
                'icon'              => 'tamtam-logo',
                'keywords'          => array('our partners', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/our_partners_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/our_partners_block.js',
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
                'icon'              => 'tamtam-logo',
                'keywords'          => array('image cta', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/image_cta_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/image_cta_block.js',

            )
        );

        // Filterable Products block
        acf_register_block_type(
            array(
                'name'              => 'filterable-products',
                'title'             => __('Filterable Products'),
                'description'       => __('A block to display filterable products.'),
                'render_template'   => 'block-templates/filterable-products-block.php',
                'category'          => 'kd',
                'icon'              => 'tamtam-logo',
                'keywords'          => array('filterable products', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/filterable_products_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/filterable_products_block.js',
            )
        );

        // Cta Section block
        acf_register_block_type(
            array(
                'name'              => 'cta-section',
                'title'             => __('CTA Section'),
                'description'       => __('A block to display CTA Section.'),
                'render_template'   => 'block-templates/cta-section-block.php',
                'category'          => 'kd',
                'icon'              => 'tamtam-logo',
                'keywords'          => array('cta section', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/cta_section_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/cta_section_block.js',
            )
        );

        // Contact Block
        acf_register_block_type(
            array(
                'name'              => 'contact',
                'title'             => __('Contact'),
                'description'       => __('A block to display contact.'),
                'render_template'   => 'block-templates/contact-block.php',
                'category'          => 'kd',
                'icon'              => 'tamtam-logo',
                'keywords'          => array('contact', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/contact_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/contact_block.js',
            )
        );

        // Catalogues Grid block
        acf_register_block_type(
            array(
                'name'              => 'catalogue-grid',
                'title'             => __('Catalogue Grid'),
                'description'       => __('A block to display catalogue grid.'),
                'render_template'   => 'block-templates/catalogue-grid.php',
                'category'          => 'kd',
                'icon'              => 'tamtam-logo',
                'keywords'          => array('catalogue grid', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/catalogue_grid.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/catalogue_grid.js',
            )
        );

        // Promotions block
        acf_register_block_type(
            array(
                'name'              => 'promotions',
                'title'             => __('Promotions'),
                'description'       => __('A block to display promotions.'),
                'render_template'   => 'block-templates/promotions-block.php',
                'category'          => 'kd',
                'icon'              => 'tamtam-logo',
                'keywords'          => array('promotions', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/promotions_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/promotions_block.js',
            )
        );

        // Salons Block
        acf_register_block_type(
            array(
                'name'              => 'salons',
                'title'             => __('Salons'),
                'description'       => __('A block to display salons.'),
                'render_template'   => 'block-templates/salons-block.php',
                'category'          => 'kd',
                'icon'              => 'tamtam-logo',
                'keywords'          => array('salons', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/salons_block.css',
                // 'enqueue_script'    => get_template_directory_uri() . '/dist/assets/salons_block.js',
            )
        );
        // Salons gallery block
        acf_register_block_type(
            array(
                'name'              => 'salons-gallery',
                'title'             => __('Salons Gallery'),
                'description'       => __('A block to display salons gallery.'),
                'render_template'   => 'block-templates/salons-gallery.php',
                'category'          => 'kd',
                'icon'              => 'tamtam-logo',
                'keywords'          => array('salons gallery', 'kd'),
                'supports'          => array(
                    'mode' => true,
                ),
                // 'enqueue_style'     => get_template_directory_uri() . '/dist/assets/salons_gallery.css',
                'enqueue_script'    => 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js',
            )
        );
    }
}
add_action('acf/init', 'tamtam_acf_init_block_types');


add_filter('script_loader_tag', function ($tag, $handle, $src) {
    // Prefix to check in the script handles
    $prefix = 'block-acf-';

    // Check if the handle starts with your prefix
    if (substr($handle, 0, strlen($prefix)) === $prefix) {
        // Modify the script tag to include type="module"
        $tag = '<script id="' . $handle . '" src="' . $src . '" type="module"></script>';
    }
    return $tag;
}, 10, 3);
