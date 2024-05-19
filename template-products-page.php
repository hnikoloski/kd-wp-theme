<?php
// Template Name: Products Page

get_header(); ?>


<div class="products-page">
    <div class="products-page__hero">
        <h1 class="products-page__hero__title"><?php the_title(); ?></h1>
        <div class="products-page__hero__image">
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover d-block">
        </div>
    </div>

    <div class="products-page__content">
        <form class="d-none products-params" id="products-params">
            <input type="hidden" name="category" value="">
            <input type="hidden" name="brand" value="">
            <input type="hidden" name="sort" value="">
            <input type="hidden" name="page" value="1">
        </form>
        <div class="products-page__content__filters">
            <div class="products-page__content-filters__category">
                <h2 class="products-page__content-filters__category__title">Product Category</h2>
                <ul class="products-page__content-filters__category__list">
                    <?php
                    $woo_product_categories = get_terms('product_cat', array('hide_empty' => 0));
                    foreach ($woo_product_categories as $woo_product_category) {
                    ?>
                        <li class="products-page__content-filters__category__item" data-category="<?php echo $woo_product_category->term_id; ?>" data-link="<?php echo get_term_link($woo_product_category); ?>">
                            <?php
                            $thumbnail_id = get_term_meta($woo_product_category->term_id, 'thumbnail_id', true);
                            $image_url = wp_get_attachment_url($thumbnail_id);
                            if (!$image_url) {
                                $image_url = wc_placeholder_img_src();
                            }
                            ?>
                            <img src="<?php echo $image_url; ?>" alt="<?php echo $woo_product_category->name; ?>">
                            <p><?php echo $woo_product_category->name; ?></p>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="products-page__content-filters__brand">
                <p class="products-page__content-filters__brand__toggle">Choose a Brand</p>
                <ul class="products-page__content-filters__brand__list">
                </ul>
            </div>
        </div>

        <div class="products-page__content__products">
            <div class="products-page__content__products__header">
                <h2 class="products-page__content__products__header__title">Products</h2>
                <div class="products-page__content__products__header__actions">
                    <ul class="products-page__content__products__header__actions__grid-selector">
                        <li class="products-page__content__products__header__actions__grid-selector__item" data-grid="2">
                            <i class="grid-2x2"></i>
                        </li>
                        <li class="products-page__content__products__header__actions__grid-selector__item" data-grid="3">
                            <i class="grid-3x3"></i>
                        </li>
                        <li class="products-page__content__products__header__actions__grid-selector__item" data-grid="4">
                            <i class="grid-4x4"></i>
                        </li>
                    </ul>
                    <div class="products-page__content__products__header__actions__sort">
                        <p>Sort by:</p>
                        <select name="sort" id="sort">
                            <option value="date">Newest</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="products-page__content__products__results" style="--columns: 3;">
                <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 12,
                    'orderby' => 'date',
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) :
                ?>
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
                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'product-card', NULL); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover" />
                                <?php if ($percentage_discount > 0) : ?>
                                    <span class="kd-filterable-products-block__results__item__discount-badge">-<?php echo $percentage_discount; ?>%</span>
                                <?php endif; ?>
                            </div>
                            <h3 class="kd-filterable-products-block__results__item__title"><?php the_title(); ?></h3>
                            <?php
                            // Check if the product has short description
                            if (has_excerpt()) {
                                echo "<p class='kd-filterable-products-block__results__item__description'>" . get_the_excerpt() . "</p>";
                            }
                            ?>
                            <p class="kd-filterable-products-block__results__item__price"><?php echo $price . " " . $price_currency; ?></p>
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>

            </div>
        </div>
        <div class="products-page__content__products__pagination d-none"></div>
    </div>
</div>
<?php get_footer(); ?>