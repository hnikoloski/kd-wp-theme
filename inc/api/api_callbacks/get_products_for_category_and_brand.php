<?php

function get_products_for_category_and_brand($request)
{
    $category_id = $request->get_param('category');
    $per_page = $request->get_param('per_page') ? $request->get_param('per_page') : 12;
    $page = $request->get_param('page') ? $request->get_param('page') : 1;
    $brand_ids = $request->get_param('brands');
    $brands = $brand_ids ? explode(',', $brand_ids) : array();

    // Arguments for WP_Query
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $per_page,
        'paged' => $page,
    );

    $tax_query = array();
    $meta_query = array();

    // Adding category filter if provided
    if (!empty($category_id)) {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category_id,
        );
    }

    // Handling brand IDs; only add to query if non-empty
    if (!empty($brands)) {
        foreach ($brands as $brand_id) {
            if (!empty($brand_id)) {
                $meta_query[] = array(
                    'key' => 'brands',
                    'value' => '"' . $brand_id . '"', // Matching serialization format
                    'compare' => 'LIKE'
                );
            }
        }

        if (!empty($meta_query)) {
            $args['meta_query'] = array(
                'relation' => 'OR', // Ensuring 'OR' logic applies between brand sub-queries
            );

            // Directly adding each condition to the meta_query array
            $args['meta_query'] = array_merge($args['meta_query'], $meta_query);
        }
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);
    $products = array();

    // Process the posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
            $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
            $price = $sale_price ? $sale_price : $regular_price;

            $percentage_discount = 0;
            if ($sale_price) {
                $percentage_discount = round((($regular_price - $sale_price) / $regular_price) * 100);
            }
            $price_currency = get_woocommerce_currency_symbol();

            $products[] = array(
                'id' => get_the_ID(),
                'permalink' => get_the_permalink(),
                'imgUrl' => get_the_post_thumbnail_url(),
                'theTitle' => get_the_title(),
                'price' => $price . " " . $price_currency,
                'percentage_discount' => $percentage_discount,
                'regular_price' => $regular_price,
                'sale_price' => $sale_price,
            );
        }
    }

    wp_reset_postdata();

    $result = array(
        'products' => $products,
        'total' => $query->found_posts,
        'max_num_pages' => $query->max_num_pages,
        'current_page' => $page,
    );

    return $result;
}
