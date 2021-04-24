<?php
namespace BESEDKA;

class DurationAvailability {
	protected $duration;
	protected $available_time; // Available time for pick duration
	
	/**
	 * DurationAvailability constructor.
	 * @param $duration { '1' | '2' | '3' | 'day' }
	 */
	public function __construct($duration)
	{
		if ( is_int($duration) ) {
			$duration = (string) $duration;
		}
		$available_values = array(
			'1',
			'2',
			'3',
			'day'
		);
		if ( ! in_array($duration, $available_values, true) ) {
			return false;
		}
		$this->duration = $duration;
	}
	
	
	public function IsDurationAvailable() {
	
	}
}