<?php

/**
 * Contact Block Template.
 */
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'kd-block kd-contact-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

$store_locations = [];
if (have_rows('store_locations', 'option')) :
    while (have_rows('store_locations', 'option')) : the_row();
        $store_locations[] = array(
            'store_name' => get_sub_field('store_name'),
            'lat' => get_sub_field('lat'),
            'lng' => get_sub_field('lng'),
        );
    endwhile;
    // Encode the array as JSON and then to base64
    $store_locations_data = base64_encode(json_encode($store_locations));
endif;

?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
    <div class="kd-contact-block__container">
        <div class="kd-contact-block__content">
            <h2 class="kd-contact-block__title"><?php the_field('title'); ?></h2>
            <form class="kd-contact-block__form" novalidate>
                <div class="kd-contact-block__form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="John Doe">
                </div>
                <div class="kd-contact-block__form-group">
                    <label for="email">E-Mail Address</label>
                    <input type="email" id="email" name="email" required placeholder="your@email.com">
                </div>
                <div class="kd-contact-block__form-group">
                    <label for="message">Phone Number</label>
                    <input type="text" id="phone" name="phone" required placeholder="+38975123456">
                </div>
                <div class="kd-contact-block__form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required placeholder="Your message here"></textarea>
                </div>
                <div class="kd-contact-block__form__footer">
                    <button type="submit" class="kd-contact-block__submit button button--primary">Send</button>
                    <div class="kd-contact-block__form__response"></div>
                </div>
            </form>
        </div>
        <div class="kd-contact-block__map">
            <?php if ($store_locations_data) : ?>
                <input type="hidden" id="store-locations" value="<?php echo esc_attr($store_locations_data); ?>">
            <?php endif; ?>
            <div id="map"></div>
        </div>
    </div>
</div>