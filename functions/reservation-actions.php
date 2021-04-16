<?php
/**
 * Removes unavailable items in cart.
 * Item unavailable if rent interval is deprecated
 * or if rent interval is intersected
 * @param $cart_items {Array}
 * @returns nothing
 */
add_action( 'remove_unavailable_items', 'remove_unavailable_items', 10, 1 );
function remove_unavailable_items( $cart_items ) {
	if ( empty($cart_items) ) {
		return;
	}
	
	require_once __DIR__ . '/bookingProduct.class.php';
	global $woocommerce;
	
	foreach ( $cart_items as $cart_item_key => $cart_item ) {
		
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$booking_product = new BESEDKA\bookingProduct($product_id);
		
		if ( $booking_product->validate() === false ) {
			continue;
		}
		
		$rent_data = [
			'start_datetime' => $cart_item['start_datetime'],
			'duration' => $cart_item['rent_duration'],
		];
		
		$booking_product->remove_outdated(); // Removes booking with expired time (default 30 minutes)
		$booking_product->remove_completed(); // Removes completed booking
		
		$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		$added_to_cart_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $cart_item['added_to_cart'], new \DateTimeZone('Europe/Moscow'));
		$expires_interval = get_field('booking_timer', get_option( 'woocommerce_shop_page_id' ));
		$expires_datetime = $added_to_cart_datetime->modify('+' . $expires_interval . ' minutes');
		
		if ( $now_datetime > $expires_datetime ) { // Booking expired
			
			$woocommerce->cart->remove_cart_item( $cart_item_key );
			continue;
			
		}
		
		if ( $booking_product->is_outdate( $rent_data ) === true ) { // Outdated booking (Returns true if end of rent interval is older than now datetime)
			
			$woocommerce->cart->remove_cart_item( $cart_item_key );
			continue;
			
		}
		
		if ( $booking_product->is_intersects( $rent_data ) === false ) { // Booking intersects with exists rent interval
			
			continue;
			
		} else {
			
			if ( isset($_COOKIE['user_key']) ) {
				
				$is_user_holder = $booking_product->is_user_holder($_COOKIE['user_key']);
				
				if ( $is_user_holder === true ) { // If user is booking owner
					continue;
				} else {
					$woocommerce->cart->remove_cart_item( $cart_item_key );
				}
			} else {
				$woocommerce->cart->remove_cart_item( $cart_item_key );
			}
		}
		
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