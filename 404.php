<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * 
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="error-404 not-found">
		<h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'starter'); ?></h1>
		<a href="<?php echo esc_url(home_url('/')); ?>" class="button button--primary"><?php esc_html_e('Go to Home', 'starter'); ?></a>
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
