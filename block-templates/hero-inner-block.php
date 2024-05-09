<?php

/**
 * Hero Inner Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-hero-inner-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}



?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
    <div class="kd-hero-inner-block__content">
        <h2 class="kd-hero-inner-block__content__title"><?php echo get_field('title'); ?></h2>
        <?php
        if (get_field('description')) {
        ?>
            <div class="kd-hero-inner-block__content__description"><?php the_field('description'); ?></div>
        <?php
        }
        ?>
    </div>
</div>