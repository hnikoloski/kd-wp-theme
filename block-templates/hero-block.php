<?php

/**
 * Hero Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-hero-block kd-hero-block-slider';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}



?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <div class="wrapper swiper-wrapper">
        <?php if (have_rows('hero_slides')) : ?>
            <?php while (have_rows('hero_slides')) : the_row(); ?>
                <?php
                $title = get_sub_field('hero_slide_title');
                $description = get_sub_field('hero_slide_description');
                $image = get_sub_field('hero_slide_image');
                $button = get_sub_field('hero_slide_button');
                ?>
                <div class="swiper-slide kd-hero-block__slide" style="--bg-image:url('<?= $image['url']; ?>');">
                    <div class="kd-hero-block__slide__content">
                        <?php if ($title) : ?>
                            <h2 class="kd-hero-block__slide__content__title"><?= $title; ?></h2>
                        <?php endif; ?>
                        <?php if ($description) : ?>
                            <?= $description; ?>
                        <?php endif; ?>
                        <?php if ($button) : ?>
                            <a href="<?= $button['url']; ?>" class="kd-hero-block__slide__content__button button button--primary"><?= $button['title']; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
        <?php
            endwhile;
        endif;
        ?>
    </div>
    <div class="kd-hero-block__pagination"></div>
</div>