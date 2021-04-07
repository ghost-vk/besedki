<?php
namespace BESEDKA;

/**
 * Class bookingProduct
 * Use for format booking data
 * @package BESEDKA
 */
class bookingFormat {
	private $property;
	
	/**
	 * Constructor
	 * @param $property
	 */
	public function __construct( $property ) {
		if ( ! isset($property) ) {
			return false;
		}
		$this->property = $property;
	}
	
	
	/**
	 * Formats start datetime option for display in UI
	 * Y-m-d H:i:s => dd/mm в hh:00
	 * @param $datetime_str
	 * @return mixed|string
	 */
	public function format_datetime_for_ui() {
		$datetime = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->property, new \DateTimeZone('Europe/Moscow') );
		if ( $datetime ) {
			$datetime_str = $datetime->format( 'd/m в H:i' );
		}
		
		return $datetime_str;
	}
	
	
	/**
	 * Formats duration option for display in UI
	 * @param $duration
	 * @return mixed|string
	 */
	public function format_duration_for_ui() {
		switch ($this->property) {
			case '1':
				$duration = '1 час';
				break;
			case '2':
				$duration = '2 часа';
				break;
			case '3':
				$duration = '3 часа';
				break;
			case 'day':
				$duration = 'Целый день';
				break;
			default:
				$duration = $this->property;
				break;
		}
		
		return $duration;
	}
	
}