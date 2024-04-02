<?php

/**
 * Filterable Products Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-filterable-products-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}



?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <div class="kd-filterable-products-block__wrapper page-padding-x bg-white">
        <?php if (get_field('title')) : ?>
            <h2 class="kd-filterable-products-block__title kd-block__title"><?= get_field('title'); ?></h2>
        <?php endif; ?>
        <div class="kd-filterable-products-block__filters">
            <ul class="kd-filterable-products-block__filters__list">
                <?php
                $terms = get_terms(array(
                    'taxonomy' => 'promotional-group',
                    'hide_empty' => false,
                ));
                // Get the first term slug
                $first_term_slug = $terms[0]->slug; // Doing it this way so we use it on the initial loop in the query
                foreach ($terms as $term) { ?>
                    <?php
                    // Add a class to the first item
                    $class = '';
                    if ($term->slug === $first_term_slug) {
                        $class = 'active';
                    }

                    ?>
                    <li class="kd-filterable-products-block__filters__list__item <?php echo $class; ?>" data-filter-id="<?= $term->term_id; ?>" data-filter-slug="<?= $term->slug; ?>">
                        <?= $term->name; ?>
                    </li>
                <?php } ?>
            </ul>
            <?php
            $products_archive_link =  get_post_type_archive_link('product');
            ?>
            <a href="<?php echo $products_archive_link; ?>" class="kd-filterable-products-block__filters__see-more">See More</a>
        </div>

        <?php
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 6,
            'tax_query' => array(
                array(
                    'taxonomy' => 'promotional-group',
                    'field' => 'slug',
                    'terms' => $first_term_slug,
                ),
            ),
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) : ?>
            <div class="kd-filterable-products-block__results">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php
                    // The woocomerce price and the discounted price and the percentage discount
                    $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
                    $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
                    $price = $sale_price ? $sale_price : $regular_price;

                    $percentage_discount = 0;
                    if ($sale_price) {
                        $percentage_discount = (($regular_price - $sale_price) / $regular_price) * 100;
                        // Round the percentage discount to a whole number
                        $percentage_discount = round($percentage_discount);
                    }
                    $price_currency = get_woocommerce_currency_symbol();
                    ?>
                    <a class="kd-filterable-products-block__results__item" href="<?php the_permalink(); ?>">
                        <div class="kd-filterable-products-block__results__item__image">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover" />
                            <?php if ($percentage_discount > 0) : ?>
                                <span class="kd-filterable-products-block__results__item__discount-badge"><?php echo $percentage_discount; ?>%</span>
                            <?php endif; ?>
                        </div>
                        <h3 class="kd-filterable-products-block__results__item__title"><?php the_title(); ?></h3>
                        <p class="kd-filterable-products-block__results__item__price"><?php echo $price . " " . $price_currency; ?></p>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>
</div>