<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * 
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="single-product__top-bar">
		<?php
		custom_breadcrumbs();

		// Back button
		$shop_url = get_permalink(wc_get_page_id('shop'));
		?>
		<a href="<?php echo $shop_url; ?>" class="single-product__back-button">
			<?php esc_html_e('Back to Products', 'starter'); ?>
		</a>
	</div>

	<div class="single-product__content">

		<?php
		$product_image = get_the_post_thumbnail_url();
		$product_image_gallery = get_post_meta(get_the_ID(), '_product_image_gallery', true);

		// Split the gallery IDs into an array
		$gallery_ids = !empty($product_image_gallery) ? explode(',', $product_image_gallery) : [];

		$all_image_urls = [];

		// Add main product image to the array
		if ($product_image) {
			$all_image_urls[] = $product_image;
		}

		// Loop through gallery IDs and add their URLs to the array
		foreach ($gallery_ids as $id) {
			$image_url = wp_get_attachment_url($id);
			if ($image_url) {
				$all_image_urls[] = $image_url;
			}
		}

		if (!empty($all_image_urls)) { ?>
			<div class="product-slider swiper">
				<div class="swiper-wrapper">
					<?php
					foreach ($all_image_urls as $url) {
					?>
						<div class="swiper-slide"><img src="<?php echo $url; ?>" alt="Product Image"></div>
					<?php
					}
					?>
				</div>
			</div>
		<?php }

		?>
	</div>


</main><!-- #main -->

<?php
get_footer();
