<?php
if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}


/**
 * starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * 
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

if (!function_exists('starter_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function starter_setup()
    {
        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on starter, use a find and replace
		 * to change 'starter' to the name of your theme in all the template files.
		 */
        load_theme_textdomain('starter', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support('title-tag');

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'menu-1' => esc_html__('Primary', 'starter'),
                'useful_links' => esc_html__('Useful Links', 'starter'),
                'privacy_policy' => esc_html__('Privacy Policy', 'starter'),
            )
        );

        /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'starter_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );
    }
endif;
add_action('after_setup_theme', 'starter_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function starter_content_width()
{
    $GLOBALS['content_width'] = apply_filters('starter_content_width', 640);
}
add_action('after_setup_theme', 'starter_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function starter_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'starter'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'starter'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'starter_widgets_init');



// Enqueue styles and scripts
require_once get_template_directory() . '/inc/enqueue.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

// Tamtam plugins
require_once get_template_directory() . '/inc/tgm/tamtam-plugins.php';

// Acf settings
require get_template_directory() . '/inc/acf/acf.php';

// Theme Editor settings
require get_template_directory() . '/inc/theme-editor-settings/theme-editor-settings.php';

// Api Endpoints
require get_template_directory() . '/inc/api/init_api.php';

// Custom Image Sizes
require get_template_directory() . '/inc/custom-image-sizes.php';


// Add taxonomy=promotional-group link to the products menu
function add_promotional_group_link()
{
    add_submenu_page(
        'edit.php?post_type=product',
        'Promotional Group',
        'Promotional Group',
        'manage_options',
        'edit-tags.php?taxonomy=promotional-group&post_type=product'
    );
}
add_action('admin_menu', 'add_promotional_group_link');


function custom_breadcrumbs()
{
    // Breadcrumbs container
    echo '<ul class="breadcrumbs">';

    // Home page
    echo '<li><a href="' . get_home_url() . '">Home</a></li>';

    // Custom post type (if applicable)
    $post_type = get_post_type();
    if ($post_type && !is_singular('page')) {
        // Get the post type object
        $post_type_object = get_post_type_object($post_type);
        echo '<li><a href="' . get_post_type_archive_link($post_type) . '">' . $post_type_object->labels->singular_name . '</a></li>';
    }

    // Categories (for hierarchical taxonomies like product categories)
    if (is_singular('product')) {
        $terms = wp_get_post_terms(get_the_ID(), 'product_cat');
        if (!empty($terms) && !is_wp_error($terms)) {
            // Get the deepest term
            $deepest_term = $terms[0];
            foreach ($terms as $term) {
                if ($term->parent > $deepest_term->parent) {
                    $deepest_term = $term;
                }
            }
            // Get hierarchical list of parent terms
            $term_hierarchy = get_ancestors($deepest_term->term_id, 'product_cat');
            $term_hierarchy = array_reverse($term_hierarchy);
            $term_hierarchy[] = $deepest_term->term_id;

            foreach ($term_hierarchy as $term_id) {
                $term_object = get_term($term_id, 'product_cat');
                echo '<li><a href="' . get_term_link($term_id, 'product_cat') . '">' . $term_object->name . '</a></li>';
            }
        }
    }

    // Current Post/Page
    if (is_singular()) {
        echo '<li>' . get_the_title() . '</li>';
    }

    // Close container
    echo '</ul>';
}
