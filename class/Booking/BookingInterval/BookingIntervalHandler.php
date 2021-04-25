<?php
namespace BESEDKA;
require_once __DIR__ . '/BookingInterval.php';
require_once __DIR__ . '/BookingIntervalOne.php';
require_once __DIR__ . '/BookingIntervalTwo.php';
require_once __DIR__ . '/BookingIntervalThree.php';
require_once __DIR__ . '/BookingIntervalDay.php';

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
	 * Switch between interval types
	 * Get interval if exists duration type
	 * @return { ['start_datetime', 'end_datetime'] }
	 */
	public function Get() {
		switch ($this->duration) {
			case ('1') :
				$interval = new BookingIntervalOne($this->start);
				break;
			case ('2') :
				$interval = new BookingIntervalTwo($this->start);
				break;
			case ('3') :
				$interval = new BookingIntervalThree($this->start);
				break;
			case ('day') :
				$interval = new BookingIntervalDay($this->start);
				break;
			default :
				return false;
		}
		
		return $interval->GetInterval();
	}
}