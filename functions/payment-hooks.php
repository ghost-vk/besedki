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
		$is_status_set = $_record->SetStatus('completed');
		if ( ! $is_status_set ) { // Record is not find
			require_once __DIR__ . '/../class/Booking/BookingDatabase.php';
			$start = $current_order->get_meta('_start_key');
			$duration = $current_order->get_meta('_duration_key');
			BESEDKA\BookingDatabase::AddBookingRecord($product_id, $start, $duration, 'completed'); // Insert new
		}
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
		error_log('Haven`t identify order cookie in function `before_checkout_create_order`!', 0);
		require_once __DIR__ . '/../class/Telegram/TelegramHandler.php';
		$_th = new Telegram\Utility\TelegramHandler('tech-support',
			'error-no-cookie-creating-order');
		$_th->CallSender();
		return;
	}
	$order->update_meta_data($time_cookie_key, $_COOKIE[$time_cookie_key]);
	$order->update_meta_data($user_key_cookie_key, $_COOKIE[$user_key_cookie_key]);
	
	update_order_meta_for_booking_record($order, '_duration');
	update_order_meta_for_booking_record($order, '_start');
	update_order_meta_for_booking_record($order, '_duration_key');
	update_order_meta_for_booking_record($order, '_start_key');
}

/**
 * Function updates meta data in order through cookie
 * @param $order { WC_Order }
 * @param $cookie_key { String }
 */
function update_order_meta_for_booking_record($order, $cookie_key) {
	if ( isset($_COOKIE[$cookie_key] ) ) {
		$order->update_meta_data($cookie_key, $_COOKIE[$cookie_key]);
	} else {
		error_log('Haven`t cookie `' . $cookie_key . '` in function `before_checkout_create_order`', 0);
	}
}