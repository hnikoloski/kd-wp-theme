<?php
function get_filterable_products($request)
{
    $per_page = $request->get_param('per_page') ? $request->get_param('per_page') : 6;
    $promotional_group = $request->get_param('promotional_group') ? $request->get_param('promotional_group') : '';
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $per_page,
    );

    if ($promotional_group) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'promotional-group',
                'field' => 'slug',
                'terms' => $promotional_group,
            ),
        );
    }

    $query = new WP_Query($args);

    $products = array();
    //permalink, imgUrl, theTitle, price, percentage_discount
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
            $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
            $price = $sale_price ? $sale_price : $regular_price;

            $percentage_discount = 0;
            if ($sale_price) {
                $percentage_discount = (($regular_price - $sale_price) / $regular_price) * 100;
                $percentage_discount = round($percentage_discount);
            }
            $price_currency = get_woocommerce_currency_symbol();

            $products[] = array(
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

    return $products;
}
