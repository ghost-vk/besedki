<?php
namespace BESEDKA;

class BookingDatabase {
	/**
	 * Method adds record to database via ACF function
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