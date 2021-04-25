<?php
namespace BESEDKA;

/**
 * Class BookingUser
 * Used for works with user data with
 * respect to booking records
 * @package BESEDKA
 */
class BookingUser {
	/**
	 * Method check user have that booking record
	 * @param $key { String } - md5 key code stores in cookies
	 * @return {Boolean} : true if user is record owner
	 */
	public function IsUserReservation($key, $product_id) {
		$rent_rows = get_field('rent_repeater', $product_id);
		if ( empty($rent_rows) || ! isset($_COOKIE['user_key']) ) {
			return false;
		}
		
		foreach ( $rent_rows as $row ) {
			if ( $row['user_key'] === $key ) {
				return true;
			}
		}
		
		return false;
	}
}