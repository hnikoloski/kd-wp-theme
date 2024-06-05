<?php

$nameSpace = 'tamtam/v1';
define('API_NAMESPACE', $nameSpace);

// Register Custom Endpoints
add_action('rest_api_init', function () use ($nameSpace) {

    // Auto complete search endpoint
    register_rest_route($nameSpace, '/auto-complete-search', array(
        'methods' => 'GET',
        'callback' => 'auto_complete_search',
        'permission_callback' => '__return_true'
    ));
    // Filterable Products
    register_rest_route($nameSpace, '/filterable-products', array(
        'methods' => 'GET',
        'callback' => 'get_filterable_products',
        'permission_callback' => '__return_true',
    ));

    // Contact form
    register_rest_route($nameSpace, '/contact-form', array(
        'methods' => 'POST',
        'callback' => 'send_contact_form_email',
        'permission_callback' => '__return_true',
    ));

    // Get Brands for a specific category
    register_rest_route($nameSpace, '/category-brands', array(
        'methods' => 'GET',
        'callback' => 'get_brands_for_category',
        'permission_callback' => '__return_true',
    ));

    // Get Products for a specific category and brand
    register_rest_route($nameSpace, '/category-brand-products', array(
        'methods' => 'GET',
        'callback' => 'get_products_for_category_and_brand',
        'permission_callback' => '__return_true',
    ));

    // Get price quote for a product
    register_rest_route($nameSpace, '/product-price-quote', array(
        'methods' => 'POST',
        'callback' => 'get_product_price_quote',
        'permission_callback' => '__return_true',
    ));

    // Salons Gallery
    register_rest_route($nameSpace, '/salons-gallery', array(
        'methods' => 'GET',
        'callback' => 'get_salons_gallery',
        'permission_callback' => '__return_true',
    ));
});


// Include all the callback files that are in the api_callbacks folder and are php files
foreach (glob(__DIR__ . '/api_callbacks/*.php') as $callback_file) {
    require_once $callback_file;
}
