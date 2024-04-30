<?php

function get_brands_for_category($request)
{
    $category = $request->get_param('category');
    $brands = array();
    $brand_ids = array(); // Array to keep track of brand IDs to avoid duplicates

    // Prepare the query arguments
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids'
    );

    // Filter by category if provided
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

    // Loop through product IDs
    if ($query->have_posts()) {
        foreach ($query->posts as $product_id) {
            $product_brands = get_field('brands', $product_id); // Fetch brands using the product ID

            // Loop through each brand related to the product
            if (!empty($product_brands)) {
                foreach ($product_brands as $brand_id) {
                    // Check for duplicate brand IDs
                    if (!in_array($brand_id, $brand_ids)) {
                        $brand_ids[] = $brand_id; // Add brand ID to the tracker array
                        $brand_name = get_the_title($brand_id); // Get the brand name by its ID
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

    // Return an error if no brands found
    if (empty($brands)) {
        return new WP_Error('no_brands', 'No brands found for the category', array('status' => 404));
    }

    return $brands;
}
