<?php
namespace BESEDKA;
require_once __DIR__ . '/../BookingInterval/BookingIntervalHandler.php';

/**
 * Class BookingCleaner
 * Used for deleting records in one product
 * @package BESEDKA
 */
class BookingCleaner {
	public $id;
	
	/**
	 * BookingCleaner constructor.
	 * @param $id { String | Integer } WC_Product ID
	 */
	public function __construct($id)
	{
		if ( ! wc_get_product($id) || ! have_rows('rent_repeater', $id) ) {
			return;
		}
		
		$this->id = $id;
		$this->now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
	}
	
	
	/**
	 * Method clean all needless records
	 */
	public function CleanNeedlessRecords() {
		$this->RemoveExpiredCartRecords();
		$this->RemoveCompletedRecords();
	}
	
	
	/**
	 * Method removed records which expired
	 * Expired interval depends on site settings
	 */
	public function RemoveExpiredCartRecords() {
		if ( ! isset($this->id) ) {
			return;
		}
		
		while ( have_rows('rent_repeater', $this->id) ) {
			the_row();
			if ( get_sub_field('rent_status') === 'added' ) { // Rent is outdated
				$added_datetime_str = get_sub_field('added_datetime'); // Datetime format 'Y-m-d H:i:s'
				$added_datetime = \DateTime::createFromFormat('Y-m-d H:i:s',
					$added_datetime_str, new \DateTimeZone('Europe/Moscow'));
				$expires_interval = get_field('booking_timer', 'options');
				$expires_datetime = $added_datetime->modify('+' . $expires_interval . ' minutes');
				
				if ( $this->now > $expires_datetime ) {
					$this->DeleteRecord();
				}
			}
		}
	}
	
	
	/**
	 * Method deletes all completed booking records for product
	 */
	public function RemoveCompletedRecords() {
		if ( ! have_rows('rent_repeater', $this->id) ) {
			return;
		}
		
		while ( have_rows('rent_repeater', $this->id) ) { // If have rent rows
			the_row();
			$duration = get_sub_field('duration');
			$start = get_sub_field('start_datetime');
			$_ih = new BookingIntervalHandler($start, $duration);
			$interval = $_ih->GetInterval();
			if ( ! $interval ) {
				return;
			}
			$interval_end =  $interval['end_datetime'];
			
			// Rent is completed
			if ( $interval_end < $this->now ) {
				$this->DeleteRecord();
			}
		}
	}
	
	
	/**
	 * Method deletes current row
	 */
	protected function DeleteRecord() {
		$row = get_row_index();
		delete_row( 'rent_repeater', $row, $this->id );
	}
}