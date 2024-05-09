<?php

/**
 * Catalogue Grid Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-catalogue-grid-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

$num_of_columns = get_field('number_of_columns');
if ($num_of_columns <= 3) {
    $image_height = 'high';
} else {
    $image_height = 'medium';
}
?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
    <div class="kd-catalogue-grid-block__row">
        <?php if (get_field('brand')) : ?>
            <div class="kd-catalogue-grid-block__brand">
                <div class="kd-catalogue-grid-block__brand__image">
                    <?php
                    $brand = get_field('brand');
                    $brand_id = $brand[0]->ID;
                    $featured_image = get_the_post_thumbnail_url($brand_id);
                    ?>
                    <img src="<?php echo $featured_image; ?>" alt="<?php echo get_the_title($brand_id); ?>" class="full-size-img full-size-img-contain d-block">
                </div>
                <?php if (get_the_excerpt($brand_id)) : ?>
                    <p class="kd-catalogue-grid-block__brand__description">
                        <?php echo get_the_excerpt($brand_id); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('catalogues')) : ?>
            <div class="kd-catalogue-grid-block__catalogues" style="--columns: <?php echo $num_of_columns; ?>;">
                <?php while (have_rows('catalogues')) : the_row(); ?>
                    <?php
                    $catalogue_cover = get_sub_field('catalogue_cover');
                    $catalogue_title = get_sub_field('catalogue_title');
                    $catalogue_file = get_sub_field('catalogue_file');
                    ?>
                    <div class="kd-catalogue-grid-block__catalogues__single image-height-<?php echo $image_height; ?>">
                        <div class="kd-catalogue-grid-block__catalogues__single__image">
                            <img src="<?php echo $catalogue_cover['url']; ?>" alt="<?php echo $catalogue_title; ?>" class="full-size-img full-size-img-cover">
                        </div>
                        <div class="kd-catalogue-grid-block__catalogues__single__content">
                            <h3 class="kd-catalogue-grid-block__catalogues__single__title"><?php echo $catalogue_title; ?></h3>
                            <a href="<?php echo $catalogue_file['url']; ?>" class="button button--primary button--medium" target="_blank">Open Catalogue</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>