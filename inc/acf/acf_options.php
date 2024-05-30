<?php

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'tamtam-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'   => 'tamtam-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'tamtam-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Social Media Settings',
        'menu_title'    => 'Social Media',
        'parent_slug'   => 'tamtam-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Promotion banner Settings',
        'menu_title'    => 'Promotion banner',
        'parent_slug'   => 'tamtam-general-settings',
    ));
    // Translations
    acf_add_options_sub_page(array(
        'page_title'    => 'Translations',
        'menu_title'    => 'Translations',
        'parent_slug'   => 'tamtam-general-settings',
    ));
}
