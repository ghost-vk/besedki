<?php
/**
 * Removes unavailable items in cart.
 * Item unavailable if expired reservation time
 * or if record interval is intersected
 * @param $cart_items {Array}
 * @returns nothing
 */
add_action( 'remove_unavailable_items', 'remove_unavailable_items', 10, 1 );
function remove_unavailable_items( $cart_items ) {
	if ( empty($cart_items) ) {
		return;
	}
	
	require_once __DIR__ . '/bookingProduct.class.php';
	require_once __DIR__ . '/../class/Booking/BookingInterval/BookingIntervalHandler.php';
	require_once __DIR__ . '/../class/Booking/BookingRecord.php';
	require_once __DIR__ . '/../class/Booking/BookingCleaner/BookingCleaner.php';
	global $woocommerce;
	
	foreach ( $cart_items as $cart_item_key => $cart_item ) {
		if ( ! isset($_COOKIE['user_key']) ) {
			$woocommerce->cart->remove_cart_item( $cart_item_key );
			return;
		}
		
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$booking_product = new BESEDKA\bookingProduct($product_id);
		
		if ( $booking_product->validate() === false ) {
			continue;
		}
		
		$rent_data = [
			'start_datetime' => $cart_item['start_datetime'],
			'duration' => $cart_item['rent_duration'],
		];
		$added_to_cart_datetime_string = $cart_item['added_to_cart'];
		
		$_cleaner = new \BESEDKA\BookingCleaner($product_id);
		$_cleaner->RemoveExpiredCartRecords();
		$booking_product->remove_outdated(); // Removes booking with expired time (default 30 minutes) TODO удалить
		
		$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		$added_to_cart_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $added_to_cart_datetime_string,
			new \DateTimeZone('Europe/Moscow'));
		$expires_interval = get_field('booking_timer', 'options');
		$expires_datetime = $added_to_cart_datetime->modify('+' . $expires_interval . ' minutes');
		
		if ( $now_datetime > $expires_datetime ) { // Booking expired
			
			$woocommerce->cart->remove_cart_item( $cart_item_key );
			continue;
			
		}
		
		if ( $booking_product->is_outdate( $rent_data ) === true ) { // Outdated booking (Returns true if end of rent interval is older than now datetime)
			
			$woocommerce->cart->remove_cart_item( $cart_item_key );
			continue;
			
		}
		
		$_br = new BESEDKA\BookingRecord($_COOKIE['user_key'], $added_to_cart_datetime_string, $product_id);
		$record = $_br->GetRecord();
		
		$_ih = new \BESEDKA\BookingIntervalHandler($cart_item['start_datetime'], $cart_item['rent_duration']);
		$is_not_intersects = $_ih->IsNotIntersects($product_id, $record);
		
		if ( $is_not_intersects === true ) { // Booking intersects with exists rent interval
			continue;
		}
		
		$woocommerce->cart->remove_cart_item( $cart_item_key );
	}
}


/**
 * Remove ACF booking row while deleting item from cart
 * @param $cart_item_key {String}
 * @param $cart {WC_Cart} object
 */
add_action( 'woocommerce_remove_cart_item', 'remove_booking_row', 10, 2 );
function remove_booking_row($cart_item_key, $cart) {
	// Get product id
	$product_id = $cart->cart_contents[ $cart_item_key ]['product_id'];
	
	// User key from cookies
	$key = $cart->cart_contents[ $cart_item_key ]['user_key'];
	
	// Also compare by start time
	$start_datetime_str = $cart->cart_contents[ $cart_item_key ]['start_datetime'];
	
	$start_datetime = DateTime::createFromFormat('Y-n-j G:i:s', $start_datetime_str);
	$formatted_start_datetime = $start_datetime->format('Y-m-d H:i:s');
	
	if ( have_rows('rent_repeater', $product_id) ) {
		while ( have_rows('rent_repeater', $product_id) ) {
			the_row();
			// If match user key from cookie and start datetime
			if (
				get_sub_field('start_datetime') === $formatted_start_datetime
				&&
				get_sub_field('user_key') === $key
			) {
				$row = get_row_index();
				delete_row( 'rent_repeater', $row, $product_id );
			}
		}
	}
}

/** AJAX */
if ( wp_doing_ajax() ) {
	require_once __DIR__ . '/../class/Booking/BookingCart.php';
	// Deletes cart items
	add_action( 'wp_ajax_empty_cart', array('BookingCart', 'ClearCart') );
	add_action( 'wp_ajax_nopriv_empty_cart', array('BookingCart', 'ClearCart') );
}