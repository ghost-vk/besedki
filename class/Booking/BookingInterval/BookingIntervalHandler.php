<?php
namespace BESEDKA;
require_once __DIR__ . '/BookingInterval.php';
require_once __DIR__ . '/BookingIntervalOne.php';
require_once __DIR__ . '/BookingIntervalTwo.php';
require_once __DIR__ . '/BookingIntervalThree.php';
require_once __DIR__ . '/BookingIntervalDay.php';
require_once __DIR__ . '/BookingIntervalComparing.php';

/**
 * Class BookingIntervalHandler
 * Used for handling different types of interval
 * @package BESEDKA
 */
class BookingIntervalHandler {
	public $start;
	public $duration;
	
	/**
	 * Constructor
	 * @param $start { '2021-05-12 13:00:00' }
	 * @param $duration { '1', '2', '3', 'day' }
	 */
	public function __construct($start, $duration) {
		$this->start = $start;
		$this->duration = $duration;
	}
	
	
	/**
	 * Method check all records in product post
	 * with product ID ($product_id)
	 * @param $product_id { '11' | 11 }
	 * @return { Boolean }
	 * @public
	 */
	public function IsNotIntersects($product_id) {
		if ( ! wc_get_product($product_id) ) {
			return false; // Like intersects
		}
		$need_to_reservation_interval = $this->GetInterval();
		if ( ! $need_to_reservation_interval ) { // Can't create interval
			return false;
		}
		while ( have_rows('rent_repeater', $product_id) ) {
			the_row();
			$start = get_sub_field('start_datetime');
			$duration = get_sub_field('duration');
			$exists_interval = $this->GetInterval($start, $duration);
			
			require_once __DIR__ . '/BookingIntervalComparing.php';
			$comparator = new BookingIntervalComparing($need_to_reservation_interval, $exists_interval);
			$is_vacant = $comparator->CheckIntersects();
			
			if ( $is_vacant === true ) { // Need interval isn't intersects with interval in current exists record
				continue;
			} else {
				return false;
			}
		}
		return true;
	}
	
	
	/**
	 * Switch between interval types
	 * Get interval if exists duration type
	 * @return { ['start_datetime', 'end_datetime'] }
	 */
	public function GetInterval($start = '_s', $duration = '_d') {
		if ( $start === '_s' ) { // Default behaviour
			$start = $this->start;
		}
		
		if ( $duration === '_d' ) { // Default behaviour
			$duration = $this->duration;
		}
		
		switch ($duration) {
			case ('1') :
				$interval = new BookingIntervalOne($start);
				break;
			case ('2') :
				$interval = new BookingIntervalTwo($start);
				break;
			case ('3') :
				$interval = new BookingIntervalThree($start);
				break;
			case ('day') :
				$interval = new BookingIntervalDay($start);
				break;
			default :
				return false;
		}
		
		return $interval->GetInterval();
	}
}