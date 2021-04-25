<?php
namespace BESEDKA;

/**
 * Class BookingInterval
 * Used for creating start and end datetime object
 * @package BESEDKA
 */
class BookingInterval {
	public $start_datetime;
	public $end_datetime;
	
	
	/**
	 * BookingInterval constructor.
	 * @param $start { '2021-05-12 13:00:00' }
	 */
	public function __construct($start)
	{
		$start_datetime = \DateTime::createFromFormat('Y-m-d H:i:s',
			$start, new \DateTimeZone('Europe/Moscow'));
		if ( ! $start_datetime ) {
			error_log('Haven`t Y-m-d H:i:s datetime string in BookingInterval constructor', 0);
			return;
		}
		$this->start_datetime = $start_datetime;
		$this->end_datetime = clone $start_datetime; // If modify without clone, original $start_datetime also modified
	}
	
	/**
	 * Method returns array of two DateTime objects - start and end point
	 * @return array|false
	 */
	public function GetInterval() {
		if ( ! $this->start_datetime ) {
			return false;
		}
		$this->CreateInterval();
		return array(
			'start_datetime' => $this->start_datetime,
			'end_datetime' => $this->end_datetime,
		);
	}
	
	/**
	 * Method creates interval (array)
	 */
	protected function CreateInterval() {
		// That method should be changed in children class
		// Should set props $start_datetime, $end_datetime
	}
}