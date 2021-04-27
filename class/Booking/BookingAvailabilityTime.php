<?php
namespace BESEDKA;

class BookingAvailability {
	/**
	 * @param $check_datetime_str { '2021-05-12 14:00:00' }
	 * @return { Boolean }
	 */
	public static function IsToday($check_datetime_ymdhis_str) {
		$check_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $check_datetime_ymdhis_str);
		if ( ! $check_datetime ) {
			return false;
		}
		
		$today_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		$check_date = $check_datetime->format('Y-m-d');
		$today_date = $today_datetime->format('Y-m-d');
		
		if ( $check_date === $today_date ) {
			return true;
		} else {
			return false;
		}
	}
}