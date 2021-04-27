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
		$is_update = false;
		while ( have_rows('rent_repeater', $this->product_id) ) {
			the_row();
			$user_key = get_sub_field('user_key');
			$added_time = get_sub_field('added_datetime');
			
			if ($user_key === $this->key && $added_time === $this->time) {
				update_sub_row('rent_status', 1, $status);
				$is_update = true;
			}
		}
		
		if ( $is_update === true ) { // Updated by strict query
			return;
		}
		
		while ( have_rows('rent_repeater', $this->product_id) ) {
			the_row();
			$user_key = get_sub_field('user_key');
			
			if ($user_key === $this->key) {
				error_log('Notice: no strict updated (not find record with match time and key)' .
				'in BookingRecord method SetStatus', 0);
				update_sub_row('rent_status', 1, $status);
				return;
			}
		}
	}
}