<?php
if ( wp_doing_ajax() ) {
	// Send available time in JSON to front-end
	add_action( 'wp_ajax_get_available_rent_time', 'get_available_rent_time' );
	add_action( 'wp_ajax_nopriv_get_available_rent_time', 'get_available_rent_time' );

	// Add booking product to cart
	add_action( 'wp_ajax_add_booking_to_cart', 'add_booking_to_cart' );
	add_action( 'wp_ajax_nopriv_add_booking_to_cart', 'add_booking_to_cart' );
	
	// Get booking product data
	add_action( 'wp_ajax_get_booking_product_data', 'get_booking_product_data' );
	add_action( 'wp_ajax_nopriv_get_booking_product_data', 'get_booking_product_data' );
}

/**
 * Function sends available time in JSON to front-end
 */
function get_available_rent_time() {
	check_ajax_referer( 'store_nonce', 'nonce' ); // Check nonce code
	
	require_once __DIR__ . '/../class/Booking/BookingAvailabilityTime.php';
	
	$available_times = (new \BESEDKA\BookingAvailabilityTime())
		->GetAvailableTime($_POST['product_id'], $_POST['rent_date']);
	$data = $available_times ? array( 'times' => $available_times ) : array( 'status' => false );
	
	wp_send_json($data);
	wp_die();
}

/**
 * Add booking variation to cart if not intersects with exists rent intervals
 */
function add_booking_to_cart() {
	check_ajax_referer('store_nonce', 'nonce'); // Check nonce code
	
	require_once __DIR__ . '/../class/Booking/BookingCart.php';
	$cart = new \BESEDKA\BookingCart($_POST['product_id'], $_POST['variation_id'], $_POST['rent_datetime'],
		$_POST['rent_duration'], $_COOKIE['user_key']);
	
	wp_send_json( array('status' => $cart->AddToCart()) );
	wp_die();
}

/**
 * Get booking data handler
 * Used for AJAX query
 */
function get_booking_product_data() {
	check_ajax_referer( 'store_nonce', 'nonce' ); // Check nonce code
	include_once __DIR__ . '/../class/Viewer/ViewerPopup.php';
	
	$data_for = $_POST['data_for'];
	$product_id = $_POST['id'];
	
	switch ( $data_for ) {
		case "popup" : {
			$viewer = new BESEDKA\ViewerPopup($product_id);
			break;
		}
		case "map" : {
			$viewer = new BESEDKA\ViewerMap($product_id);;
			break;
		}
		default : {
			error_log('$viewer object was not defined in function `get_booking_product_data`');
			wp_die();
			break;
		}
	}
	
	wp_send_json($viewer->Get());
	wp_die();
}





