<?php
// Template Name: Brands Archive

get_header();
?>

<main id="primary" class="site-main brands-archive">
    <div class="brands-archive__hero">
        <h1 class="brands-archive__hero__title"><?php the_title(); ?></h1>
    </div>

    <div class="brands-archive__content">
        <?php
        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );

        $brands = new WP_Query($args);

        if ($brands->have_posts()) {
            while ($brands->have_posts()) {
                $brands->the_post();
                $brand_id = get_the_ID();
                $brand_name = get_the_title();
                $brand_image = get_the_post_thumbnail_url();
                $brand_link = get_field('brand_website', $brand_id);
                $brand_excerpt = get_the_excerpt();
                $gallery = get_field('gallery', $brand_id);

                // Add odd or even depending on the place in the loop
                $class = $brands->current_post % 2 == 0 ? 'content-left' : 'content-right';
        ?>
                <div class="brands-archive__content__single <?php echo $class; ?>">
                    <div class="brands-archive__content__single__col">
                        <div class="brands-archive__content__single__info">
                            <div class="brands-archive__content__single__info__image">
                                <img src="<?php echo $brand_image; ?>" alt="<?php echo $brand_name; ?>" class="full-size-img full-size-img-cover d-block">
                            </div>
                            <h2 class="brands-archive__content__single__info__title"><?php echo $brand_name; ?></h2>
                            <div class="brands-archive__content__single__info__excerpt">
                                <p>
                                    <?php echo $brand_excerpt; ?>
                                </p>
                            </div>
                            <?php if ($brand_link) : ?>
                                <a href="<?php echo $brand_link; ?>" class="brands-archive__content__single__info__link button button--just-text"><?php echo $brand_link; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="brands-archive__content__single__gallery">
                        <div class="brands-archive__content__single__gallery__swiper swiper">
                            <div class="swiper-wrapper">
                                <?php
                                if ($gallery) {
                                    foreach ($gallery as $image) {
                                ?>
                                        <div class="swiper-slide">
                                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="full-size-img full-size-img-cover d-block">
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="swiper-button-next"><i></i></div>
                            <div class="swiper-button-prev"><i></i></div>
                        </div>


                    </div>
                </div>
        <?php
            }
        }
        wp_reset_postdata();
        ?>
    </div>


</main><!-- #main -->

<?php
get_footer();
