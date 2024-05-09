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
		// Get the page with shop page template
		$shop_url = get_page_by_path('shop');
		$shop_url = get_permalink($shop_url);
		?>
		<a href="<?php echo $shop_url; ?>" class="single-product__back-button">
			<?php esc_html_e('Back to Products', 'starter'); ?>
		</a>
	</div>

	<div class="single-product__content">
		<div class="single-product__content__gallery">
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
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				</div>
				<div class="product-slider-thumbs swiper" thumbsSlider="">
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
		<div class="single-product__content__info">
			<h1 class="single-product__content__info__title"><?php the_title(); ?></h1>
			<?php
			// Short description
			if (has_excerpt()) {
			?>
				<div class="single-product__content__info__description"><?php the_excerpt(); ?></div>
			<?php
			}
			// Check if it has brands acf
			$brands = get_field('brands');
			if (!empty($brands)) {
			?>
				<div class="single-product__content__info__brands">
					<?php
					foreach ($brands as $brand) {
						$brand_name = get_the_title($brand);
						// Get featured image url
						$brand_image = get_the_post_thumbnail_url($brand);

					?>
						<?php if ($brand_image) { ?>
							<img src="<?php echo $brand_image; ?>" alt="<?php echo $brand_name; ?>" class="single-product__content__info__brands__image">
						<?php } ?>
					<?php
					}
					?>
				</div>
			<?php
			}

			?>
			<p class="single-product__content__info__category">
				<?php
				$categories = get_the_terms(get_the_ID(), 'product_cat');
				if (!empty($categories)) {
					$category = $categories[0];
					if ($category->name !== 'Uncategorized') {
						// Check if the category is not Uncategorized
						echo 'Category: ' . $category->name;
					}
				}
				?>
			</p>
			<div class="single-product__content__info__footer">
				<button class="single-product__content__info__get-price button button--primary button--medium">Get a price</button>
			</div>
		</div>

	</div>

	<div class="single-product__similar-products">
		<h2 class="single-product__similar-products__title">Similar Products</h2>
		<div class="single-product__similar-products__products swiper">
			<div class="swiper-wrapper">
				<?php

				$current_product_id = get_the_ID();
				$current_product_categories = wp_get_post_terms($current_product_id, 'product_cat', array("fields" => "ids"));

				// Arguments for related products
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => 8,  // Adjust number of similar products shown
					'post__not_in' => array($current_product_id),  // Exclude current product
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'id',
							'terms' => $current_product_categories
						)
					)
				);

				$similar_products = new WP_Query($args);

				if ($similar_products->have_posts()) {
					while ($similar_products->have_posts()) {
						$similar_products->the_post();
				?>
						<?php
						// The woocomerce price and the discounted price and the percentage discount
						$regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
						$sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
						$price = $sale_price ? $sale_price : $regular_price;

						$percentage_discount = 0;
						if ($sale_price) {
							$percentage_discount = (($regular_price - $sale_price) / $regular_price) * 100;
							// Round the percentage discount to a whole number
							$percentage_discount = round($percentage_discount);
						}
						$price_currency = get_woocommerce_currency_symbol();
						?>
						<div class="swiper-slide">
							<a class="kd-filterable-products-block__results__item" href="<?php the_permalink(); ?>">
								<div class="kd-filterable-products-block__results__item__image">
									<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'product-card', NULL); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover" />
									<?php if ($percentage_discount > 0) : ?>
										<span class="kd-filterable-products-block__results__item__discount-badge">-<?php echo $percentage_discount; ?>%</span>
									<?php endif; ?>
								</div>
								<h3 class="kd-filterable-products-block__results__item__title"><?php the_title(); ?></h3>
								<?php
								// Check if the product has short description
								if (has_excerpt()) {
									echo "<p class='kd-filterable-products-block__results__item__description'>" . get_the_excerpt() . "</p>";
								}
								?>
								<p class="kd-filterable-products-block__results__item__price"><?php echo $price . " " . $price_currency; ?></p>
							</a>
						</div>
				<?php
					}
				} else {
					echo '<p>No similar products found.</p>';
				}

				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>

</main><!-- #main -->

<div class="single-product__modal">
	<div class="single-product__modal__dialog">
		<div class="single-product__modal__dialog__content">
			<button class="single-product__modal__dialog__close-button">
				x
			</button>
			<p>Leave your information below, and our dedicated team will reach out to provide you with tailored pricing options and answer any questions you may have.</p>
			<form class="single-product__modal__dialog__form" novalidate>
				<div class="single-product__modal__dialog__form__group">
					<label for="full_name">Full Name</label>
					<input type="text" id="full_name" name="full_name" required placeholder="Full Name">
				</div>
				<div class="single-product__modal__dialog__form__group">
					<label for="email">E-Mail Address</label>
					<input type="email" id="email" name="email" required placeholder="your@email.com">
				</div>
				<div class="single-product__modal__dialog__form__group">
					<label for="phone">Phone Number</label>
					<input type="text" id="phone" name="phone" required placeholder="+38975123456">
				</div>
				<input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">

				<div class="single-product__modal__dialog__form__footer">
					<div class="single-product__modal__dialog__form__response"></div>
					<button type="submit" class="single-product__modal__dialog__submit button button--primary button--medium">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
get_footer();
