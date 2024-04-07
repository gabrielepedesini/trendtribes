<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product-infos', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php

		woocommerce_template_single_title();
		woocommerce_template_single_rating();
		woocommerce_template_single_price();

		?>
		
		<div class="free-shipping">
			<img style="height: 13px" src="<?php echo get_template_directory_uri(); ?>/img/shipping.svg" alt="">
			<span style="font-size: 14px">Free shipping </span>
		</div>

		<?php

		woocommerce_template_single_add_to_cart();
		// woocommerce_template_single_meta();

		?>

		<div class="desc">
			<?php echo $product->get_description(); ?>
		</div>
		
		<?php

		$product_attributes = $product->get_attributes();
		$firstAccordion = true;

		foreach ($product_attributes as $attribute) {

			if ($attribute->get_visible()) {
				
				if ($firstAccordion) {
					echo '<div class="product-summary-accordion" style="border-top: 1px solid var(--light-gray)">';
					$firstAccordion = false;
				} else {
					echo '<div class="product-summary-accordion">';
				}
				echo '<div class="product-detail-title">';
				echo '<h3>' . $attribute->get_name() . '</h3> ';
				echo '<img src="' . get_template_directory_uri() . '/img/down-arrow.svg">';
				echo '</div>';
				echo '<div class="accordion-desc">' . implode($attribute->get_options()) . '</div>';

				if($attribute->get_name() == 'Size Chart') {
					$sizing_image_url = get_post_meta(get_the_ID(), '_sizing_image', true);
					if (!empty($sizing_image_url)) {
						echo '<img src="' . esc_url($sizing_image_url) . '" alt="Sizing Image" style="max-width: 100%;">';
					}
				}

				echo '</div>';
			}
		}
		
		woocommerce_template_single_sharing();


		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		// do_action( 'woocommerce_single_product_summary' );
		?>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_after_single_product_summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */

// do_action( 'woocommerce_after_single_product_summary' );

if ( comments_open() ) {
	// Display the reviews section
	comments_template();
}

woocommerce_output_related_products();

?>

<?php do_action( 'woocommerce_after_single_product' ); ?>
