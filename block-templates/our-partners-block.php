<?php

/**
 * Hero Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-partnes-block kd-partnes-block-slider';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}



?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <div class="wrapper swiper-wrapper">
        <?php if (have_rows('partner_logos')) : ?>
            <?php while (have_rows('partner_logos')) : the_row(); ?>
                <?php
                $image = get_sub_field('partner_logo');
                ?>
                <div class="swiper-slide kd-partnes-block__slide" style="--bg-image:url('<?= $image['url']; ?>');">
                    <div class="kd-partnes-block__slide__content">
                        <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                    </div>
                </div>
        <?php
            endwhile;
        endif;
        ?>

    </div>
</div>