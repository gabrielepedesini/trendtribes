<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<p class="woocommerce-result-count">
	<?php
	
	global $wp_query;

	$total_products = wc_get_loop_prop('total'); // Total number of products.

	$paged    = max(1, get_query_var('paged')); // Current page number.
	$per_page = wc_get_loop_prop('per_page'); // Products per page.

	if ($total_products == 1) {
		// If there is only one product.
		echo sprintf(_n('Showing 1 of 1 result', 'Showing 1 of 1 results', $total_products, 'woocommerce'));
	} elseif ($total_products <= $per_page || -1 === $per_page) {
		// If there's only one page, or all products are shown on a single page.
		echo sprintf(_n('Showing 1–%1$s of %2$s result', 'Showing 1–%1$s of %2$s results', $total_products, 'woocommerce'), $total_products, $total_products);
	} else {
		// If there's more than one page.
		$first = ($per_page * $paged) - $per_page + 1;
		$last  = min($total_products, $per_page * $paged);
		echo sprintf(_n('Showing %1$s–%2$s of %3$s result', 'Showing %1$s–%2$s of %3$s results', $total_products, 'woocommerce'), $first, $last, $total_products);
	}

	?>
</p>
