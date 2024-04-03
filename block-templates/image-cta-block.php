<?php

/**
 * ImageCta Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-image-cta-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <div class="kd-image-cta-block__wrapper">
        <div class="kd-image-cta-block__content">
            <?php if (get_field('title')) : ?>
                <?php
                $title_tag = get_field('title_tag') ? get_field('title_tag') : 'h2';
                $title_underline = get_field('title_underline') ? 'kd-image-cta-block__content__title--underline' : '';
                ?>
                <?php
                printf('<%s class="kd-image-cta-block__content__title %s">%s</%s>', $title_tag, $title_underline, get_field('title'), $title_tag);
                ?>
            <?php endif; ?>
            <?php
            if (get_field('description')) :
            ?>
                <div class="kd-image-cta-block__content__description"><?= get_field('description'); ?></div>
            <?php endif; ?>
            <?php
            if (get_field('button')) :
            ?>
                <a href="<?= get_field('button')['url']; ?>" class="kd-image-cta-block__content__button button button--just-text color-red"><?= get_field('button')['title']; ?></a>
            <?php endif; ?>
        </div>
        <?php
        if (get_field('image')) :
        ?>
            <div class="kd-image-cta-block__image" style="--bg-image:url('<?= get_field('image')['url']; ?>');"></div>
        <?php endif; ?>

    </div>
</div>