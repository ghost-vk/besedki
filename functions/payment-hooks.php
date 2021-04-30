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
 * Function works only for
 */
add_action( 'woocommerce_order_status_completed', 'change_booking_status' );
function change_booking_status( $order_id ) { // TODO Протестировать функцию с боевой платежной системой
	require_once __DIR__ . '/../class/Booking/BookingRecord.php';
	$current_order = wc_get_order( $order_id );
	$current_items = $current_order->get_items();
	$added_to_cart_time = $current_order->get_meta('_added_to_cart');
	$user_key = $current_order->get_meta('user_key');
	
	if ( ! isset($added_to_cart_time) || ! isset($user_key) ) {
		error_log('Can`t get record: order hasn`t meta `_added_to_cart` or(and) `user_key`', 0);
		return;
	}
	
	foreach ( $current_items as $item ) {
		$product_id = $item->get_product_id();
		$_record = new \BESEDKA\BookingRecord($user_key, $added_to_cart_time, $product_id);
		$_record->SetStatus('completed');
	}
}

/**
 * Add meta data to order which help identify record
 */
add_action('woocommerce_checkout_create_order', 'before_checkout_create_order', 20, 2);
function before_checkout_create_order( $order, $data ) { // That works
	$time_cookie_key = '_added_to_cart';
	$user_key_cookie_key = 'user_key';
	if ( ! isset($_COOKIE[$time_cookie_key]) || ! isset($_COOKIE[$user_key_cookie_key]) ) {
		return;
	}
	$order->update_meta_data($time_cookie_key, $_COOKIE[$time_cookie_key]);
	$order->update_meta_data($user_key_cookie_key, $_COOKIE[$user_key_cookie_key]);
	
	if ( isset($_COOKIE['_duration']) ) {
		$order->update_meta_data('_duration', $_COOKIE['_duration']);
	}
	
	if ( isset($_COOKIE['_start']) ) {
		$order->update_meta_data('_start', $_COOKIE['_start']);
	}
}