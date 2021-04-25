<?php
namespace BESEDKA;
require_once __DIR__ . '/BookingInterval.php';

class BookingIntervalDay extends BookingInterval {
	public function CreateInterval () {
		$hour = $this->end_datetime->format('G');
		$hour_int = (int)$hour;
		if ( $hour_int >= 0 && $hour_int <= 4 ) { // Whole day duration in 00:00 - 05:00
			$this->end_datetime = $this->end_datetime->setTime( 5, 0 );
		} else { // Default
			$next_day = $this->end_datetime->modify('+1 day');
			$this->end_datetime = $next_day->setTime( 5, 0 );
		}
	}
}