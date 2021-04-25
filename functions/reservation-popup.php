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
 * Send available time in JSON to front-end
 */
function get_available_rent_time() {
	check_ajax_referer( 'store_nonce', 'nonce' ); // Check nonce code
	
	require_once __DIR__ . '/bookingProduct.class.php';
	
	$product_id = $_POST['product_id'];
	if ( !wc_get_product($product_id) ) {
		wp_die();
	}
	
	$booking_product = new BESEDKA\bookingProduct($product_id);
	if ( $booking_product->validate() !== true ) {
		wp_die();
	}
	$rent_date = $_POST['rent_date'];
	if ( ! isset($rent_date) ) {
		wp_die();
	}
	
	$available_times = $booking_product->get_available_time($rent_date); // In this method also removes outdated bookings
	
	$data = [
		'id' => $product_id,
		'date' => $rent_date,
		'times' => $available_times,
	];
	
	wp_send_json($data);
	wp_die();
}


/**
 * Add booking variation to cart if not intersects with exists rent intervals
 */
function add_booking_to_cart() {
	check_ajax_referer( 'store_nonce', 'nonce' ); // Check nonce code
	
	$product_id = $_POST['product_id'];
	$variation_id = $_POST['variation_id'];
	if ( ! wc_get_product($product_id) || ! wc_get_product($variation_id) ) {
		wp_send_json( array(
			'status' => false,
			'error' => 'No such product',
		));
		wp_die();
	}
	
	require_once __DIR__ . '/bookingProduct.class.php';
	
	$booking_product = new BESEDKA\bookingProduct($product_id);
	if ( $booking_product->validate() !== true ) {
		wp_die();
	}
	
	$start_datetime_str = $_POST['rent_datetime'];
	$duration = $_POST['rent_duration'];
	
	if ( ! $start_datetime_str || ! $duration ) {
		wp_send_json( array(
			'status' => false,
			'error' => 'No datetime or duration',
		));
		wp_die();
	}
	
	$rent_data = array (
		'start_datetime' => $start_datetime_str,
		'duration' => $duration,
		'variation_id' => $variation_id,
	);
	
	$is_product_add_to_cart = $booking_product->add_to_cart( $rent_data );
	
	$data = array ( 'status' => $is_product_add_to_cart );
	
	wp_send_json($data);
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





