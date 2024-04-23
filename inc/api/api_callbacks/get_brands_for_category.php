<?php

function get_brands_for_category($request)
{
    $category = $request->get_param('category');
    $brands = array();
    // Get all products in the category
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );

    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category,
            ),
        );
    }

    $query = new WP_Query($args);

    // Check if the query has posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Get the brand ACF relationship field for each product
            $product_brands = get_field('brands');

            // If there are brands, loop through them and add to the brands array
            if (!empty($product_brands)) {
                foreach ($product_brands as $brand_id) {
                    // Check if the brand ID is not already in the array to avoid duplicates
                    if (!array_key_exists($brand_id, $brands)) {
                        // Assume the brand is a custom post type, get the brand name using get_the_title
                        $brand_name = get_the_title($brand_id);
                        $brands[] = array(
                            'id' => $brand_id,
                            'name' => $brand_name,
                        );
                    }
                }
            }
        }
    }
    // Reset post data to ensure global post data is restored
    wp_reset_postdata();

    if (empty($brands)) {
        return new WP_Error('no_brands', 'No brands found for the category', array('status' => 404));
    }

    return $brands;
}
