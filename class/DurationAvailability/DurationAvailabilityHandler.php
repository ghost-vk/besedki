<?php
namespace BESEDKA;
require_once __DIR__ . '/DurationAvailability.php';
require_once __DIR__ . '/DurationAvailabilityOneHour.php';

class DurationHandler {
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
	
	public function IsAvailable() {
		switch ($this->duration) {
			case ('1') :
				$duration_availability = new DurationAvailabilityOneHour($this->start_datetime);
				break;
			default :
				return;
		}
		
		echo "<br>Availability :<br>";
		var_dump($duration_availability->IsDurationAvailable());
		
//		return $duration_availability->IsDurationAvailable();
	}
}