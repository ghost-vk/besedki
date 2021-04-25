<?php
namespace BESEDKA;
require_once __DIR__ . '/BookingInterval.php';

class BookingIntervalTwo extends BookingInterval {
	public function CreateInterval () {
		$this->end_datetime = $this->end_datetime->modify('+2 hour');
	}
}