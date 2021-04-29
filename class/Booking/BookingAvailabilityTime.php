<?php
namespace BESEDKA;
require_once __DIR__ . '/BookingCleaner/BookingCleaner.php';
/**
 * Class BookingAvailability
 * Used for get booking available time
 * @package BESEDKA
 */
class BookingAvailabilityTime {
	
	/**
	 * Method checks today date
	 * @param $check_datetime_ymd_str { '2021-05-12 14:00:00' }
	 * @return { Boolean }
	 */
	public function IsToday($check_datetime_ymd_str) {
		$check_datetime = $this->CreateDatetime('Y-m-d', $check_datetime_ymd_str);
		if ( ! $check_datetime ) {
			error_log('Haven`t create datetime in method IsToday (class BookingAvailabilityTime)');
			return false;
		}
		
		$today_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		
		if ( $check_datetime->format('Y-m-d') === $today_datetime->format('Y-m-d') ) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Handler for getting available time
	 * @param $id { String | Integer } WC_Product ID
	 * @param $date { '2021-05-12' }
	 */
	public function GetAvailableTime($id, $date) {
		// 0. Check product id
		if ( ! wc_get_product($id) ) {
			return false;
		}
		
		// 1. First remove needless record
		(new BookingCleaner($id))->RemoveExpiredCartRecords();
		
		$need_datetime = $this->CreateDatetime('Y-m-d', $date);
		if ( ! $need_datetime ) { // If is not right date format
			return false;
		}
		$date = $need_datetime->format('Y-m-d');
		
		// 2. Get initial time parameters
		$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		$current_hour_str = $now_datetime->format('H:00');
		$current_hour_int = (int)$now_datetime->format('G');
		
		// 3. Get working hours
		$default_available_times = $this->GetDefaultTimes();
		
		// 4. Cutting time before current hour (f.e. 14:00 is not available if now is 15:00)
		$is_today = $this->IsToday($date);
		if ( $is_today === true) {
			$default_available_times = $this->CutDefaultTimes($current_hour_str, $default_available_times);
		}
		
		// 5. Returns only working hours if there are no record for that product
		if ( ! have_rows('rent_repeater', $id) ) { // If no rent records in product
			return $default_available_times;
		}
		
		// 6. Get periods of existing booking record for product in that day
		$rent_periods = $this->GetRentPeriods($id, $date);
		if ( empty($rent_periods) ) {
			return $default_available_times;
		}
		
		// 7. Get not working hours and add to that hours before
		$not_allowed_hours = $this->GetNotAllowedHours();
		if ( $is_today ) {
			$not_allowed_hours = $this->ExcludeHoursBeforeCurrentHourToday($current_hour_int, $not_allowed_hours);
		}
		
		// 8. Adding for not allowed hours placed (booked) hours
		$not_allowed_hours = $this->ExcludePlacedHours($rent_periods, $not_allowed_hours);
		
		return $this->CreateFormattedHoursArray($not_allowed_hours);
	}
	
	
	/**
	 * Method creates datetime object in Moscow time zone
	 * @param $type
	 * @param $datetime_str
	 * @return \DateTime|false
	 */
	protected function CreateDatetime($type, $datetime_str) {
		return \DateTime::createFromFormat($type, $datetime_str,
			new \DateTimeZone('Europe/Moscow'));
	}
	
	
	/**
	 * Method returns working hours
	 * @return string[]
	 */
	protected function GetDefaultTimes() {
		// 5:00 to 10:00 should be unavailable
		return array(
			'00:00', '01:00', '02:00', '03:00', '04:00',
			'10:00', '11:00', '12:00', '13:00', '14:00',
			'15:00', '16:00', '17:00', '18:00', '19:00',
			'20:00', '21:00', '22:00', '23:00'
		);
	}
	
	
	/**
	 * Method returns not working hours
	 * @return int[]
	 */
	protected function GetNotAllowedHours() {
		return array(5, 6, 7, 8, 8, 9);
	}
	
	
	/**
	 * Method returns working hours for current day
	 * @param $current_hour
	 * @param $times
	 * @return mixed
	 */
	protected function CutDefaultTimes($current_hour, $times) {
		$length = 0;
		foreach ( $times as $key => $time ) {
			if ( $current_hour >= $time ) {
				$length = $key + 1;
			}
		}
		
		if ( $length > 0 ) {
			array_splice($times, 0, $length);
		}
		
		return $times;
	}
	
	
	/**
	 * Method returns periods constructed by exists booking records
	 * @param $id
	 * @param $need_date
	 * @return array
	 */
	protected function GetRentPeriods($id, $need_date) {
		require_once __DIR__ . '/BookingInterval/BookingIntervalHandler.php';
		$_ih = new BookingIntervalHandler();
		$rent_periods = array();
		
		while ( have_rows('rent_repeater', $id) ) {
			the_row();
			$rent_interval = $_ih->GetInterval(get_sub_field('start_datetime'), get_sub_field('duration'));
			
			$start_date = $rent_interval['start_datetime']->format('Y-m-d');
			$finish_date = $rent_interval['end_datetime']->format('Y-m-d');
			
			$start_hour = (int)$rent_interval['start_datetime']->format('H');
			$end_hour = (int)$rent_interval['end_datetime']->format('H');
			
			if ( $start_date === $need_date ) { // Find match : date which need to get available time is ...
				if ( $start_hour > $end_hour ) { // If rent starts in one day, but ends the next day
					$end_hour = 24;
				} else { // Starts and ends the same day
					$end_hour -= 1; // Booking should be available just after ends previous booking
				}
				$rent_periods[] = array(
					'start' => $start_hour,
					'end' => $end_hour,
				);
			} elseif ( $finish_date == $need_date ) {
				$rent_periods[] = array(
					'start' => 0,
					'end' => $end_hour - 1, // Rent starts just after ends previous booking
				);
			}
		}
		
		return $rent_periods;
	}
	
	
	/**
	 * Method adds hours to exclusion before current hour today
	 * @param $current_hour_int
	 * @param array $hours
	 * @return array|mixed
	 */
	protected function ExcludeHoursBeforeCurrentHourToday($current_hour_int, $hours = array()) {
		for ( $i = 0; $i <= $current_hour_int; $i += 1 ) {
			$hours[] =  $i;
		}
		return $hours;
	}
	
	
	/**
	 * Method adds placed to exclusion for placed rent periods
	 * @param $rent_periods
	 * @param $hours
	 * @return int[]
	 */
	protected function ExcludePlacedHours($rent_periods, $hours) {
		foreach ( $rent_periods as $period ) {
			$hour_qty = $period['end'] - $period['start'];
			for ( $i = 0; $i <= $hour_qty; $i += 1 ) {
				$hours[] = $period['start'] + $i;
			}
		}
		
		return $hours;
	}
	
	
	/**
	 * Method returns time available for booking
	 * @param $not_allowed_hours
	 * @return string[]
	 */
	protected function CreateFormattedHoursArray($not_allowed_hours): array
	{
		$allowed_hours = array();
		
		for ( $i = 0; $i < 24; $i += 1 ) {
			if ( in_array($i, $not_allowed_hours, true) ) { // Only if hour available
				continue;
			}
			$allowed_hours[] = ( $i < 10 ) ? "0$i:00" : "$i:00";
		}
		
		return $allowed_hours;
	}
}