<?php

namespace BESEDKA;

use http\Params;

/**
 * Class bookingProduct
 * @package BESEDKA
 */
class bookingProduct {
	private $id;
	
	/**
	 * Constructor
	 * @param $product_id {String|Integer}
	 */
	public function __construct($product_id) {
		if ( gettype($product_id) !== 'integer' ) {
			$product_id = (int)$product_id;
			if ( $product_id <= 0 || gettype($product_id) !== 'integer' ) {
				return;
			}
		}
		$this->id = $product_id;
	}
	
	
	/**
	 * Validates ID property. If can get product by ID validate is successful
	 * @return bool
	 */
	public function validate() {
		if ( ! $this->id ) {
			return false;
		}
		$product = wc_get_product( $this->id );
		if ( get_class($product) !== 'WC_Product_Variable' ) {
			return false;
		}
		return true;
	}
	
	
	/**
	 * Removes completed rent rows from product post.
	 */
	public function remove_completed() {
		if ( ! have_rows('rent_repeater', $this->id) ) {
			return;
		}
		
		$yesterday_datetime = new \DateTime('yesterday', new \DateTimeZone('Europe/Moscow'));
		$yesterday_datetime->add(\DateInterval::createFromDateString('yesterday'));
		
		while ( have_rows('rent_repeater', $this->id) ) { // If have rent rows
			the_row();
			$start_datetime = get_sub_field('start_datetime');
			$start_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $start_datetime, new \DateTimeZone('Europe/Moscow'));
			
			// Rent is completed ($yesterday here is yesterday at 00:00,
			// f.e., if today is 04/02 14:00, yesterday is 02/02 00:00)
			if ( $start_datetime < $yesterday_datetime ) {
				$row = get_row_index();
				delete_row( 'rent_repeater', $row, $this->id );
			}
		}
	}
	
	
	/**
	 * Deletes ACF rows with rend data in outdated bookings
	 */
	public function remove_outdated() {
		if ( have_rows('rent_repeater', $this->id) ) {
			while ( have_rows('rent_repeater', $this->id) ) {
				the_row();
				if ( get_sub_field('rent_status') === 'added' ) { // Rent is outdated
					$added_str = get_sub_field('added_datetime'); // Datetime format 'Y-m-d H:i:s'
					$added_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $added_str, new \DateTimeZone('Europe/Moscow'));
					$expires_interval = get_field('booking_timer', get_option( 'woocommerce_shop_page_id' ));
					$expires_datetime = $added_datetime->modify('+' . $expires_interval . ' minutes');
					$now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
					
					if ( $now > $expires_datetime ) {
						$row = get_row_index();
						delete_row( 'rent_repeater', $row, $this->id );
					}
				}
			}
		}
	}
	
	
	/**
	 * Get array of DateTime objects from string datetime format
	 * @param $start {String} 'Y-m-d H:i:s'
	 * @param $duration {String}, available values : '1', '2', '3', 'day'
	 * @returns array - Keys:
	 * 	'start_datetime' => DateTime
	 * 	'end_datetime' => DateTime
	 */
	public function get_interval($start, $duration) {
		$start_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $start, new \DateTimeZone('Europe/Moscow'));
		
		if ( ! $start_datetime ) {
			return;
		}
		
		$end_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $start, new \DateTimeZone('Europe/Moscow'));
		
		switch ( $duration ) {
			case '1':
				$end_datetime = $end_datetime->modify('+1 hour');
				break;
			case '2':
				$end_datetime = $end_datetime->modify('+2 hour');
				break;
			case '3':
				$end_datetime = $end_datetime->modify('+3 hour');
				break;
			case 'day': // TODO Set next day
				$end_datetime = $end_datetime->setTime( 22, 0 ); // When day type reservation ends
				break;
		}
		
		return array(
			'start_datetime' => $start_datetime,
			'end_datetime' => $end_datetime
		);
	}
	
	
	/**
	 * Compares two datetime intervals
	 * @param $need_interval {Array}
	 * @param $exist_interval {Array}
	 * @return bool - false if intersects
	 */
	private function compare_intervals($need_interval, $exist_interval) {
		if (
			$need_interval['start_datetime'] > $need_interval['end_datetime']
			OR
			$exist_interval['start_datetime'] > $exist_interval['end_datetime']
		) {
			error_log ("Задан не правильный интервал: начало интервала позже окончания", 0);
			return true;
		}
		
		if (
			$need_interval['start_datetime'] == $exist_interval['start_datetime']
			OR
			$need_interval['end_datetime'] == $exist_interval['end_datetime']
		) { // If starts or ends is equal
			return false;
		}
		
		if ( $need_interval['start_datetime'] < $exist_interval['start_datetime'] ) {
			if (
				$need_interval['end_datetime'] > $exist_interval['start_datetime']
				AND
				$need_interval['end_datetime'] < $exist_interval['end_datetime']
			) {
				return false;
			}
			
			if ( $need_interval['end_datetime'] > $exist_interval['end_datetime'] ) {
				return false;
			}
		}
		else
		{
			if (
				$exist_interval['end_datetime'] > $need_interval['start_datetime']
				AND
				$exist_interval['end_datetime'] < $need_interval['end_datetime']
			) {
				return false;
			}
			
			if ( $exist_interval['end_datetime'] > $need_interval['end_datetime'] ) {
				return false;
			}
			
		}
		
		return true;
		
	}
	
	
	/**
	 * @param $need_interval {Array} - constructed by "get_interval"
	 * @return {Boolean} if 5 - 9 o'clock returns false
	 */
	public function check_allowed_time($need_interval) {
		if (
			! $need_interval['start_datetime']
			OR
			! $need_interval['end_datetime']
			OR
			! $need_interval['start_datetime'] instanceof \DateTime
			OR
			! $need_interval['end_datetime'] instanceof \DateTime
		) {
			return false;
		}
		
		$start_hour = (int)$need_interval['start_datetime']->format('H');
		$end_hour = (int)$need_interval['end_datetime']->format('H');
		
		if ( $start_hour > 4 && $start_hour < 10 ) { // Start hour between 4:00 and 10:00
			return false;
		}
		
		if ( $end_hour > 4 && $end_hour < 10 ) { // End hour between 4:00 and 10:00
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Check reservation period. If period is not intersects with exists returns false;
	 * @param $data {Array} contains start datetime and duration
	 * $data['start_datetime'] - a string time formated "Y-m-d H:i:s"
	 * $data['duration'] - one of '1', '2', '3', 'day'
	 * @return bool|void
	 */
	public function is_intersects ($data) {
		if ( ! isset($data['start_datetime']) || ! isset($data['duration']) ) {
			return;
		}
		
		$need_interval = $this->get_interval( $data['start_datetime'], $data['duration'] );
		
		if ( ! have_rows('rent_repeater', $this->id) ) { // If haven't rents
			return false;
		}
		
		while ( have_rows('rent_repeater', $this->id) ) {
			the_row();
			$start = get_sub_field('start_datetime');
			$duration = get_sub_field('duration');
			$exists_interval = $this->get_interval($start, $duration);
			$is_vacant = $this->compare_intervals($need_interval, $exists_interval);
			$is_allowed_time = $this->check_allowed_time($need_interval);
			
			if ( $is_vacant === true && $is_allowed_time ) { // Not intersects and time not in 5:00 - 9:00
				continue;
			} else {
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 * Check need date is today
	 * @param $datetime_str {String} format "Y-m-d H:i:s"
	 * @return bool
	 */
	public function is_today ($datetime_str) {
		$check_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $datetime_str);
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
	
	
	/**
	 * Check outdated rent. Returns true if end of rent interval is older than now datetime.
	 * @param $data {Array} contains start datetime and duration
	 * $data['start_datetime'] - a string time formated "Y-m-d H:i:s"
	 * $data['duration'] - one of '1', '2', '3', 'day'
	 * @return bool|void
	 */
	public function is_outdate($data) {
		if ( ! isset($data['start_datetime']) || ! isset($data['duration']) ) {
			return;
		}
		
		$need_interval = $this->get_interval( $data['start_datetime'], $data['duration'] );
		if ( ! isset($need_interval['end_datetime']) ) {
			return;
		}
		
		$end_datetime = $need_interval['end_datetime'];
		
		if ( ! $end_datetime ) {
			return;
		}
		
		$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		
		if ( $end_datetime <= $now_datetime ) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Insert reservation data to database
	 * @param $data {Array} contains Start time and rent duration
	 * @returns {Integer|Boolean} New row quantity or false
	 */
	public function insert_row($data, $status) {
		if (
			gettype($this->id) !== 'integer' // Not ID
				OR
			! isset($data['start_datetime']) // Not set start time
				OR
			! isset($data['duration']) // Not set duration
				OR
			! isset($status)
		) {
			return;
		}
		
		$data['rent_status'] = $status;
		$data['user_key'] = $_COOKIE['user_key'];
		
		switch ( $status ) {
			case 'completed' :
				if ( $this->is_intersects($data) === false ) {
					return add_row( 'rent_repeater', $data, $this->id );
				}
				break;
			case 'added' :
				if ( $this->is_intersects($data) === false ) {
					$now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
					$data['added_datetime'] = $now->format('Y-m-d H:i:s');
					return add_row( 'rent_repeater', $data, $this->id );
				}
				break;
			default :
				break;
		}
	}
	
	
	/**
	 * Add rent product to cart
	 * Returns true if product added to cart
	 * $data['start_datetime'] - a string time formated 'Y-m-d H:i:s'
	 * $data['duration'] - one of '1', '2', '3', 'day'
	 * @param $data {Array} contains Start time and rent duration
	 * @return bool|void
	 */
	public function add_to_cart($data) {
		if (
			gettype($this->id) !== 'integer' // Not ID
			OR
			! isset($data['start_datetime']) // Not set start time
			OR
			! isset($data['duration']) // Not set duration
			OR
			! isset($data['variation_id']) // Not set variation
		) {
			return false;
		}
		
		global $woocommerce;
		
		if ( ! wc_get_product($data['variation_id']) ) {
			return false;
		}
		
		if ( $this->is_intersects($data) === false ) {
			$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
			
			if ( $this->is_today($data['start_datetime']) === true ) { // If need to rent day is today
				$start_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $data['start_datetime']);
				if ( $now_datetime > $start_datetime ) { // If time is up
					return false;
				}
			}
			
			$add_to_cart = $woocommerce->cart->add_to_cart( $data['variation_id'], 1, 0, array(), array (
				'start_datetime' => $data['start_datetime'],
				'rent_duration' => $data['duration'],
				'added_to_cart' => $now_datetime->format('Y-m-d H:i:s'),
				'user_key' => $_COOKIE['user_key'],
			) );
			
			if ( $add_to_cart ) { // If added to cart
				$insert_row = $this->insert_row( $data, 'added' );
				if ( $insert_row ) { // If inserted row
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Get array of time available to rent
	 * @param $date {String} Y-m-d format
	 * @return array|string[]|void
	 */
	public function get_available_time($date) {
		$this->remove_outdated(); // Remove expires bookings, f.e +30 minutes after adding to cart
		
		$need_datetime = \DateTime::createFromFormat('Y-m-d', $date, new \DateTimeZone('Europe/Moscow'));
		if ( ! $need_datetime ) { // If is not right date format
			return;
		}
		$need_date = $need_datetime->format('Y-m-d');
		
		// 5:00 to 10:00 should be unavailable
		$available_times = array(
			'00:00', '01:00', '02:00', '03:00', '04:00',
			'10:00', '11:00', '12:00', '13:00', '14:00',
			'15:00', '16:00', '17:00', '18:00', '19:00',
			'20:00', '21:00', '22:00', '23:00'
		);
		
		$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		$current_hour = $now_datetime->format('H:00');
		
		$is_today = $this->is_today($date . ' 12:00:00');
		if ( $is_today === true ) { // If today - get only later current hours
			$length = 0;
			foreach ( $available_times as $key => $time ) {
				if ( $current_hour >= $time ) {
					$length = $key + 1;
				}
			}
			
			if ( $length > 0 ) {
				array_splice($available_times, 0, $length);
			}
		}
		
		$loop_available_times = array();
		$rent_periods = array();
		
		if ( ! have_rows('rent_repeater', $this->id) ) { // If no rent records in product
			return $available_times;
		}
		
		// Constructs rent periods of exists bookings
		while ( have_rows('rent_repeater', $this->id) ) {
			the_row();
			$rent_interval = $this->get_interval( get_sub_field('start_datetime'), get_sub_field('duration') );
			
			if ( ! $rent_interval ) {
				error_log ("Haven't get time interval in function 'get_available_time'", 0);
				return [];
			}
			
			$rent_start = $rent_interval['start_datetime'];
			$rent_finish = $rent_interval['end_datetime'];
			
			if ( ! $rent_start || ! $rent_finish ) { // If DateTime return false
				error_log ("Haven't get DateTime object in get_available_time", 0);
				return [];
			}
			
			$start_date = $rent_start->format('Y-m-d');
			$finish_date = $rent_finish->format('Y-m-d');
			
			$start_hour = (int)$rent_start->format('H');
			$end_hour = (int)$rent_finish->format('H');
			
			// При прохождении цикла по записям бронирования всегда будет срабатывать только $start_date == $need_date
			if ( $start_date == $need_date ) { // Find match : date which need to get available time is ...
				if ( $start_hour > $end_hour ) { // If rent starts in one day, but ends the next day
					$end_hour = 24;
				} else { // Starts and ends the same day
					$end_hour -= 1; // Rent starts just after ends previous booking
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
		
		if ( ! empty($rent_periods) ) { // If have rent records in needed day
			$not_allowed_hours = array( // This time is not available for booking
				5,
				6,
				7,
				8,
				8,
				9,
			);
			
			// Exclude hours before current time if today
			if ( $is_today === true ) {
				$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
				$current_hour = (int)$now_datetime->format('H');
				for ( $i = 0; $i <= $current_hour; $i += 1 ) {
					$not_allowed_hours[] =  $i;
				}
			}
			
			// Exclude hours which are already busy for booking
			foreach ( $rent_periods as $period ) {
				$hour_qty = $period['end'] - $period['start'];
				for ( $i = 0; $i <= $hour_qty; $i += 1 ) {
					$not_allowed_hours[] = $period['start'] + $i;
				}
			}
			
			for ( $i = 0; $i < 24; $i += 1 ) {
				if ( ! in_array($i, $not_allowed_hours, true) ) { // If hour available
					
					if ( $i < 10) { // 01:00 - 09:00
						$loop_available_times[] = "0$i:00";
					} else {
						$loop_available_times[] = "$i:00";
					}
					
				}
			}
			
			if ( ! empty($loop_available_times) ) {
				return $loop_available_times;
			}
		}
		
		return $available_times;
	}
	
	
	/**
	 * Changes booking status in product type post
	 * @param $status {String} Can be "added" or "completed"
	 * @param $key {String} Booking key - every user has such key in cookie
	 */
	public function change_booking_status($status, $key) {
		if ( have_rows('rent_repeater', $this->id) && isset($key) ) {
			while ( have_rows('rent_repeater', $this->id) ) {
				the_row();
				$user_key = get_sub_field('user_key');
				
				if ( ! $user_key || $key !== $user_key ) {
					continue;
				}
				
				$new_value = $status;
				update_sub_row('rent_status', 1, $new_value);
			}
		} else {
			error_log('Не найдены строки бронирования в функции "change_booking_status"', 0);
		}
	}
	
	
	/**
	 * Check is current user holder of booking
	 * If current user added booking to cart - he is holder
	 * Returns true if current user is holder
	 * $key is md5 string stores in $_COOKIE
	 * @param $key {String}
	 * @returns {Boolean}
	 */
	public function is_user_holder($key) {
		$rent_rows = get_field('rent_repeater', $this->id);
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