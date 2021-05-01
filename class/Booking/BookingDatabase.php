<?php
namespace BESEDKA;

class BookingDatabase {
	/**
	 * Method adds record to database via ACF function
	 * @param $id { String | Integer } WC_Product ID
	 * @param $start { 'Y-m-d H:i:s' } Start booking datetime string
	 * @param $duration { '1' | '2' | '3' | 'day' } String
	 * @param $status { 'added' | 'completed' } String
	 * @param $cart_time { 'Y-m-d H:i:s' } Added to cart datetime string
	 * @param $key { String } user key stores in cookie
	 */
	public static function AddBookingRecord($id, $start, $duration, $status = 'added', $cart_time = null, $key = null) {
		if ( ! wc_get_product($id) ) { // No such product
			return;
		}
		
		if ( ! isset($start) || ! isset($duration) ) {
			return;
		}
		
		$data = array(
			'start_datetime' => $start,
			'duration' => $duration,
			'rent_status' => $status,
			'added_datetime' => $cart_time,
			'user_key' => $key
		);
		
		return add_row('rent_repeater', $data, $id);
	}
}