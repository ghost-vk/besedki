<?php
namespace BESEDKA;
require_once __DIR__ . '/BookingInterval.php';

class BookingIntervalOne extends BookingInterval {
	public function CreateInterval () {
		$this->end_datetime = $this->end_datetime->modify('+1 hour');
	}
}