<?php

/**
 * Salons Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-salons-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <div class="kd-salons-block__wrapper">
        <?php if (get_field('title')) : ?>
            <?php
            $title_tag = get_field('title_tag') ? get_field('title_tag') : 'h2';
            ?>
            <?php
            printf('<%s class="kd-salons-block__title">%s</%s>', $title_tag, get_field('title'), $title_tag);
            ?>
        <?php endif; ?>

        <?php
        $args = array(
            'post_type' => 'salon',
            'posts_per_page' => -1,
        );

        $salons = new WP_Query($args);
        if ($salons->have_posts()) :
        ?>
            <div class="kd-salons-block__salons">
                <?php while ($salons->have_posts()) : $salons->the_post(); ?>
                    <div class="kd-salons-block__salon">
                        <h3 class="kd-salons-block__salon__title"><?php the_title(); ?></h3>
                        <div class="kd-salons-block__salon__image">
                            <?php
                            // Featured image from the post
                            $featured_image =  get_the_post_thumbnail_url(get_the_ID(), 'full');
                            ?>
                            <?php if ($featured_image) : ?>
                                <img src="<?= $featured_image; ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover d-block">
                            <?php endif; ?>
                        </div>
                        <div class="kd-salons-block__salon__content">
                            <?php if (get_field('address', get_the_ID())) : ?>
                                <div class="kd-salons-block__salon__content__address">
                                    <?= get_field('address', get_the_ID()); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (get_field('phone', get_the_ID())) : ?>
                                <div class="kd-salons-block__salon__content__phone">
                                    <p><?= get_field('phone', get_the_ID()); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if (get_field('fax', get_the_ID())) : ?>
                                <div class="kd-salons-block__salon__content__fax">
                                    <p><?= get_field('fax', get_the_ID()); ?></p>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
    </div>
<?php
        endif;
        wp_reset_postdata();
?>
</div>