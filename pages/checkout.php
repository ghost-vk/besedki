<?php
global $woocommerce;
$cart_items = $woocommerce->cart->get_cart();
do_action( 'remove_unavailable_items', $cart_items ); // Remove items with expired reservation time
do_action( 'remove_cart_items_from_second_one', $cart_items ); // Remove items from second one (save only first)

if ( $woocommerce->cart->is_empty() === true ) { // If cart is empty after deleting unavailable booking
	if ( ! is_wc_endpoint_url( 'order-received' ) ) {
		header('Location: ' . home_url('/reservation'));
	}
}
?>
<?php get_header(); ?>
	<div class="cartBody">
		<div class="container">
			<?php echo do_shortcode("[woocommerce_checkout]"); ?>
		</div>
	</div>
<?php get_footer(); ?>