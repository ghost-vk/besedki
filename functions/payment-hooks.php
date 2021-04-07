<?php
/**
 * This hooks turn status complete for every order upon payment.
 */
add_filter( 'woocommerce_order_item_needs_processing', 'need_processing_false_filter' );
// See class-wc-order line 1368 to understand the return value
function need_processing_false_filter() {
	return false;
}

/**
 * Set booking status completed after successful payment
 */
add_action( 'woocommerce_order_status_completed', 'change_booking_status' );
function change_booking_status( $order_id ) { // TODO Протестировать функцию с боевой платежной системой
	require_once __DIR__ . '/bookingProduct.class.php';
	$current_order = wc_get_order( $order_id );
	$current_items = $current_order->get_items();
	foreach ( $current_items as $item ) {
		$product_id = $item->get_product_id();
		$booking_product = new BESEDKA\bookingProduct($product_id);
		if ( $booking_product->validate() !== true  || ! isset($_COOKIE['user_key']) ) {
			continue;
		}
		$booking_product->change_booking_status('completed', $_COOKIE['user_key']);
	}
}