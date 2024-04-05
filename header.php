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
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                    )
                );
                ?>
            </nav><!-- #site-navigation -->

            <div id="menu-trigger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            </ul>
        </header><!-- #masthead -->