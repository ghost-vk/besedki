<?php
namespace BESEDKA;

class BookingRecord {
	public $key; // User key stores in cookies
	public $time; // Add to cart time for finding record in batch
	public $product_id;
	public $all_records;
	
	/**
	 * BookingRecord constructor.
	 * @param $key { String }
	 * @param $time { 'Y-m-d H:i:s' }
	 * @param $product_id { WC_Product ID }
	 */
	public function __construct($key, $time, $product_id) {
		$this->key = $key;
		$this->time = $time;
		$this->product_id = $product_id;
		$this->all_records = get_field('rent_repeater', $this->product_id);
	}
	
	
	/**
	 * Extract one record from records batch in product post
	 * @return { Array | false }
	 */
	public function GetRecord() {
		if ( empty($this->all_records) ) {
			error_log('Can`t find record in function `remove_unavailable_items`');
			return false;
		}
		foreach ($this->all_records as $record) {
			if ($record['user_key'] === $this->key && $record['added_datetime'] === $this->time) {
				return $record;
			}
		}
		return false;
	}
	
	
	/**
	 * Changes status in booking record
	 * @param $status { 'completed' | 'added' }
	 */
	public function SetStatus($status) {
		while ( have_rows('rent_repeater', $this->product_id) ) { // Try to find record in exist
			the_row();
			$user_key = get_sub_field('user_key');
			$added_time = get_sub_field('added_datetime');
			
			if ($user_key === $this->key && $added_time === $this->time) { // Found record
				update_sub_row('rent_status', 1, $status);
				return true;
			}
		}
		
		// Sending fail status to Telegram
		$this->SendError();
		return false;
	}
	
	/**
	 * Method send error to tech-support in telegram
	 */
	protected function SendError() {
		error_log('Fail when set status in booking record', 0);
		require_once __DIR__ . '/../Telegram/TelegramHandler.php';
		$args = array( 'product_name' => get_the_title($this->product_id) );
		$_th = new \Telegram\Utility\TelegramHandler('tech-support',
			'error-change-booking-status', $args);
		$_th->CallSender();
	}
}