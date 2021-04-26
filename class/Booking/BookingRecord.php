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
		foreach ( $this->all_records as $record ) {
			if ( $record['user_key'] === $this->key && $record['added_datetime'] === $this->time ) {
				return $record;
			}
		}
		return false;
	}
}