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
                    'hide_empty' => true,
                ));
                foreach ($terms as $term) { ?>
                    <li class="kd-filterable-products-block__filters__list__item" data-filter-id="<?= $term->term_id; ?>" data-filter-slug="<?= $term->slug; ?>">
                        <?= $term->name; ?>
                    </li>
                <?php } ?>
            </ul>
            <?php
            $products_archive_link =  get_post_type_archive_link('products');
            ?>
            <a href="<?php echo $products_archive_link; ?>" class="kd-filterable-products-block__filters__see-more">See More</a>
        </div>
    </div>
</div>