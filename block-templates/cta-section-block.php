<?php

/**
 * CTA Section Block Template.
 */
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-cta-section-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}
$bgColor = get_field('background_color') ? get_field('background_color') : '#191919';
?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>" style="--bg-color:<?php echo $bgColor; ?>">
    <div class="kd-cta-section-block__wrapper page-padding-x">
        <div class="kd-cta-section-block__image">
            <?php
            if (get_field('image')) :
                $imageAlt = get_field('image')['alt'] ? get_field('image')['alt'] : get_field('title');
            ?>
                <img src="<?php echo get_field('image')['url']; ?>" alt="<?php echo $imageAlt; ?>" class="full-size-img full-size-img-contain d-block">
            <?php endif; ?>
        </div>
        <div class="kd-cta-section-block__content">
            <?php if (get_field('title')) : ?>
                <?php
                $title_tag = get_field('title_tag') ? get_field('title_tag') : 'h2';
                ?>
                <?php
                printf('<%s class="kd-cta-section-block__content__title color-white">%s</%s>', $title_tag, get_field('title'), $title_tag);
                ?>
            <?php endif; ?>

            <?php
            if (get_field('button')) :
            ?>
                <a href="<?php echo get_field('button')['url']; ?>" class="kd-cta-section-block__content__button button button--primary"><?php echo get_field('button')['title']; ?></a>
            <?php endif; ?>

        </div>
    </div>
</div>