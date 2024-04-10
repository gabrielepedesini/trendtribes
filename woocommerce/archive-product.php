<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>

<main class="container">

	<div class="group">

		<div class="products-list">

			<?php

			/**
			 * Hook: woocommerce_before_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 * @hooked WC_Structured_Data::generate_website_data() - 30
			 */
			do_action( 'woocommerce_before_main_content' );

			?>

			<header class="woocommerce-products-header">

				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
				<?php endif; ?>

				<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action( 'woocommerce_archive_description' );

				?>

			</header>

			<?php

			if ( woocommerce_product_loop() ) {

				echo '<div class="pre-shop-infos">';
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

				echo '<a class="mobile-filters-btn"><span>Filters</span></a>';

				echo '</div>';
			
			?>

			<?php
				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();

						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action( 'woocommerce_shop_loop' );

						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();

			} else {

				echo '<div class="no-product-found-filter">';

				echo '<a class="mobile-filters-btn"><span>Filters</span></a>';

				echo '</div>';

				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			}

			/**
			 * Hook: woocommerce_after_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );

			?>

		</div>

		<div class="products-filter">

			<div class="filters-cross">
                <img src="<?php echo get_template_directory_uri(); ?>/img/cross.svg" alt="">
            </div>

			<h2 class="title-category title-filters-categories">Popular Categories</h2>

			<div class='container-categories'>

				<?php
				echo do_shortcode('[product_categories number="0" parent="0" columns="1" orderby="popularity"]');
				?>

			</div>

			<div class="btn-show-categories-container">
				<a class="btn-show-categories">View All</a>
			</div>

			<div style='height: 50px' class='filter-spacer'></div>

			<h2 class="title-category" style="margin-bottom: 25px;">Filters</h2>

			<?php
			echo do_shortcode('[custom_filter]');
			?>

		</div>

	</div>
	
	<?php
	woocommerce_pagination()
	?>

</main>

<?php

get_footer();

?>