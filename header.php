<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * 
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class('overflow-hidden'); ?>>
    <?php wp_body_open();
    require('template-parts/preloader.php');
    $custom_logo_id = get_theme_mod('custom_logo');
    $logoUrl = wp_get_attachment_image_src($custom_logo_id, 'full');
    $logoWidth = get_field('logo_width', 'option') ? get_field('logo_width', 'option') : '191';
    // Include template-parts/promos.php
    if (get_field('enable_promo_banner', 'option') === true) {
        require(get_template_directory() . '/template-parts/promotional-banner.php');
    }
    ?>
    <div id="page" class="site">
        <header id="masthead" class="site-header page-padding-x">
            <a href="<?= home_url(); ?>" class="logo-wrapper d-block" style="--logo-width:<?php echo $logoWidth; ?>px;">
                <img src="<?= $logoUrl[0]; ?>" alt="<?= get_bloginfo(); ?>" class="full-size-img full-size-img-contain d-block">
            </a>

            <nav id="site-navigation" class="main-navigation">
                <div class="mob-menu-close">
                    <p>Menu</p>
                    <i></i>
                </div>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                    )
                );
                ?>

                <?php
                // Language switcher
                // echo do_shortcode('[language-switcher]');
                ?>
                <button id="search-trigger" class="search-trigger">
                    <i></i>
                </button>
                <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                    <label>
                        <span class="screen-reader-text">Search for:</span>
                        <input type="search" class="search-field" placeholder="Search …" value="<?php echo get_search_query(); ?>" name="s" title="Search for:" autocomplete="off" /> </label>
                    <button class="search-close"><i></i><span class="screen-reader-text">Close</span></button>
                </form>
            </nav><!-- #site-navigation -->
            <div class="mob-wrapper">
                <a href="tel:<?= get_field('mobile_phone_num', 'option'); ?>" class="header-phone-number"><i></i></a>
                <div id="menu-trigger">
                    <p>MENU</p>
                    <div class="hamburger-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </header><!-- #masthead -->

        <a id="back-to-top" href="#page" class="back-to-top" aria-label="Back to top">
            <i></i>
        </a>