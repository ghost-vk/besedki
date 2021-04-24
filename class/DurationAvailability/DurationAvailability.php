<?php
namespace BESEDKA;

/**
 * Class DurationAvailability
 * Used for check availability of duration type
 * with respect to start hour
 * @package BESEDKA
 */
class DurationAvailability {
	protected $duration; // Need rent duration '1', '2', '3', 'day'
	protected $available_time = array(); // Available time for pick duration [ ['value', 'label'] ]
	protected $start_hour;
	
	/**
	 * DurationAvailability constructor.
	 * @param $start_datetime { '2021-05-12 13:00:00' }
	 */
	public function __construct($start_datetime) {
		$datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $start_datetime);
		if ( $datetime !== false ) {
			$this->start_hour = $datetime->format('G');
		}
	}
	
	
	/**
	 * Method checks duration available
	 */
	public function IsDurationAvailable() {
		
		if ( empty($this->available_time) || ! $this->start_hour ) { // Time wasn't setup
			return true;
		}
		
		foreach  ( $this->available_time as $hour_data ) {
			if ( $hour_data['value'] === $this->start_hour ) {
				return false;
			}
		}
		
		return true;
	}
	
	
	/**
	 * Method for testing input data
	 */
	public function GetData() {
		var_dump($this->available_time);
		var_dump($this->start_hour);
	}
}