<?php
namespace BESEDKA;
require_once __DIR__ . '/DurationAvailability.php';
require_once __DIR__ . '/DurationAvailabilityOneHour.php';
require_once __DIR__ . '/DurationAvailabilityTwoHours.php';
require_once __DIR__ . '/DurationAvailabilityThreeHours.php';
require_once __DIR__ . '/DurationAvailabilityWholeDay.php';

/**
 * Class DurationAvailabilityHandler
 * Abstraction for using DurationAvailability classes
 * @package BESEDKA
 */
class DurationAvailabilityHandler {
	protected $duration;
	protected $start_datetime;
	
	/**
	 * DurationHandler constructor.
	 * @param $duration { '1', '2', '3', 'day' }
	 * @param $start_datetime { '2021-05-12 14:00:00' }
	 */
	public function __construct($duration, $start_datetime)
	{
		$this->duration = $duration;
		$this->start_datetime = $start_datetime;
	}
	
	/**
	 * Method check availability of duration start hour
	 * through instances of child DurationAvailability class
	 * @return { Boolean }
	 */
	public function IsAvailable() {
		switch ($this->duration) {
			case ('1') :
				$duration_availability = new DurationAvailabilityOneHour($this->start_datetime);
				break;
			case ('2') :
				$duration_availability = new DurationAvailabilityTwoHours($this->start_datetime);
				break;
			case ('3') :
				$duration_availability = new DurationAvailabilityThreeHours($this->start_datetime);
				break;
			case ('day') :
				$duration_availability = new DurationAvailabilityWholeDay($this->start_datetime);
				break;
			default :
				error_log('Wrong duration in DurationAvailabilityHandler', 0);
				return false;
		}
		
		return $duration_availability->IsDurationAvailable();
	}
}