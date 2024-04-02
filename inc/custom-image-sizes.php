<?php
// custom-image-sizes.php
// Add custom image sizes
add_action('after_setup_theme', 'starter_custom_image_sizes');
function starter_custom_image_sizes()
{
    // Var dump all the image sizes
    add_image_size('product-card', 410, 389, true);
}
