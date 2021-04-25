<?php
namespace BESEDKA;

/**
 * Class BookingIntervalComparing
 * Used for compare intervals
 * @package BESEDKA
 */
class BookingIntervalComparing {
	public $first_start;
	public $first_end;
	public $second_start;
	public $second_end;
	
	/**
	 * BookingIntervalComparing constructor.
	 * @param $first_interval [ DateTime, DateTime ]
	 * @param $second_interval [ DateTime, DateTime ]
	 */
	public function __construct($first_interval, $second_interval)
	{
		if ( ! isset($first_interval['start_datetime'] ) || ! $first_interval['start_datetime'] instanceof \DateTime ) {
			return;
		}
		if ( ! isset($first_interval['end_datetime'] ) || ! $first_interval['end_datetime'] instanceof \DateTime ) {
			return;
		}
		if ( ! isset($second_interval['start_datetime'] ) || ! $second_interval['start_datetime'] instanceof \DateTime ) {
			return;
		}
		if ( ! isset($second_interval['end_datetime'] ) || ! $second_interval['end_datetime'] instanceof \DateTime ) {
			return;
		}
		
		$this->first_start = $first_interval['start_datetime'];
		$this->first_end = $first_interval['end_datetime'];
		
		$this->second_start = $second_interval['start_datetime'];
		$this->second_end = $second_interval['end_datetime'];
	}
	
	/**
	 * Compares two datetime intervals
	 * @return {Boolean}
	 * If intersects - false
	 */
	public function CheckIntersects() {
		if (
			$this->first_start > $this->first_end
			OR
			$this->second_start > $this->second_end
		) {
			error_log ("Wrong interval: start more than end", 0);
			return false;
		}
		
		if (
			$this->first_start == $this->second_start
			OR
			$this->first_end == $this->second_end
		) { // If starts or ends is equal
			return false;
		}
		
		if ( $this->first_start < $this->second_start ) {
			if (
				$this->first_end > $this->second_start
				AND
				$this->first_end < $this->second_end
			) {
				return false;
			}
			
			if ( $this->first_end > $this->second_end ) {
				return false;
			}
		}
		else
		{
			if (
				$this->second_end > $this->first_start
				AND
				$this->second_end < $this->first_end
			) {
				return false;
			}
			
			if ( $this->second_end > $this->first_end ) {
				return false;
			}
			
		}
		
		return true;
	}
}