<?php

/**
 * Catalogue Grid Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-promotions-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
    <?php if (have_rows('promotions')) : ?>
        <?php while (have_rows('promotions')) : the_row();
            $promotion_image = get_sub_field('promotion_image');
            $promotion_title = get_sub_field('promotion_title');
            $promotion_title_color = get_sub_field('promotion_title_color') ?: '#000000';
            $highlighted_words = get_sub_field('highlighted_words');
            $highlighted_words_color = get_sub_field('highlighted_words_color') ?: '#ED3237';
            $promotion_link = get_sub_field('promotion_link');
            $promotion_validity = get_sub_field('promotion_validity');
            $promotion_validity_color = get_sub_field('promotion_validity_color') ?: '#fff';

            $styled_title = $promotion_title;
            if ($highlighted_words) {
                $replace = '<span style="color: ' . esc_attr($highlighted_words_color) . ';">' . esc_html($highlighted_words) . '</span>';
                $styled_title = str_replace($highlighted_words, $replace, $promotion_title);
            }

            $content_background = get_sub_field('content_background');
            $odd_even = get_row_index() % 2 === 0 ? 'even' : 'odd';
        ?>
            <div class="kd-promotions-block__promotion <?php echo esc_attr($odd_even); ?>">
                <div class="kd-promotions-block__promotion__image">
                    <img src="<?php echo esc_url($promotion_image['url']); ?>" alt="<?php echo esc_attr($promotion_title); ?>" class="full-size-img full-size-img-cover">
                </div>
                <div class="kd-promotions-block__promotion__content" style="background-color: <?php echo esc_attr($content_background); ?>;">
                    <h3 class="kd-promotions-block__promotion__content__title" style="color: <?php echo esc_attr($promotion_title_color); ?>">
                        <?php echo $styled_title; ?>
                    </h3>
                    <?php if ($promotion_validity) : ?>
                        <p class="kd-promotions-block__promotion__content__validity" style="color: <?php echo esc_attr($promotion_validity_color); ?>">
                            Valid until <?php echo esc_html($promotion_validity); ?></p>
                    <?php endif; ?>
                    <?php if ($promotion_link) : ?>
                        <a href="<?php echo esc_url($promotion_link); ?>" class="kd-promotions-block__promotion__content__link button button--primary">View</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>