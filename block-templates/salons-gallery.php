<?php

/**
 * Salons Gallery Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-salons-gallery-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <div class="kd-salons-gallery-block__wrapper">
        <button class="kd-salons-gallery-block__toggler" data-active-text="Collapse Gallery"><span>Expand Gallery</span> <i></i></button>
        <div class="kd-salons-gallery-block__toggle-wrap">
            <div class="kd-salons-gallery-block__header">
                <h4 class="kd-salons-gallery-block__title">View Options</h4>
                <ul class="kd-salons-gallery-block__filters">
                    <?php
                    $salons = get_posts(array(
                        'post_type' => 'salon',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ));
                    foreach ($salons as $salon) {
                        $salon_id = $salon->ID;
                        $salon_title = $salon->post_title;
                        $salon_slug = $salon->post_name;
                        $is_first = $salon_id === $salons[0]->ID;
                    ?>
                        <li class="kd-salons-gallery-block__filter <?= $is_first ? 'active' : ''; ?>" data-salon=" <?= $salon_id; ?>">
                            <?= $salon_title; ?>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="kd-salons-gallery-block__gallery-results">
            </div>
        </div>
    </div>
</div>