<?php
namespace BESEDKA;

class BookingCart {
	public $product_id;
	public $variation_id;
	public $start;
	public $duration;
	public $user_key;
	
	/**
	 * BookingCart constructor.
	 * @param $product_id { String | Integer } WC_Product_Variable ID
	 * @param $variation_id { String | Integer } WC_Product_Variation ID
	 * @param $start { '2021-05-12 13:00:00' }
	 * @param $duration { '1' | '2' | '3' | 'day' }
	 * @param $user_key { String }
	 */
	public function __construct($product_id, $variation_id, $start, $duration, $user_key) {
		$product = wc_get_product($product_id);
		if ( ! $product ) {
			return;
		}
		if ( get_class($product) !== 'WC_Product_Variable' ) {
			return;
		}
		if ( get_class(wc_get_product($variation_id)) !== 'WC_Product_Variation' ) {
			return;
		}
		if ( ! \DateTime::createFromFormat('Y-m-d H:i:s', $start) ) {
			return;
		}
		$available_duration = array('1', '2', '3', 'day');
		if ( ! in_array($duration, $available_duration, true) ) {
			return;
		}
		if ( ! $user_key ) {
			return;
		}
		
		$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		$now_datetime_str = $now_datetime->format('Y-m-d H:i:s');
		
		$this->product_id = $product_id;
		$this->variation_id = $variation_id;
		$this->start = $start;
		$this->duration = $duration;
		$this->user_key = $user_key;
		$this->added_time = $now_datetime_str;
	}
	
	/**
	 * @param $product_id
	 * @param $variation_id
	 * @param $start
	 * @param $duration
	 * @param $user_key
	 * @return false
	 */
	public function AddToCart() {
		if ( ! $this->product_id ) {
			return false;
		}
		
		global $woocommerce;
		
		// 1. Check duration availability
		require_once __DIR__ . '/../DurationAvailability/DurationAvailabilityHandler.php';
		$is_duration_available = (new DurationAvailabilityHandler($this->duration, $this->start))->IsAvailable();
		if ( ! $is_duration_available ) { // Type of duration with this start hour is not available
			return false;
		}
		
		// 2. Check intersects with exists records
		require_once __DIR__ . '/BookingInterval/BookingIntervalHandler.php';
		$interval_handler = new BookingIntervalHandler($this->start, $this->duration);
		$is_not_intersects_with_exists_record = $interval_handler->IsNotIntersects($this->product_id);
		if ( $is_not_intersects_with_exists_record === false ) { // Reversed
			return false;
		}
		
		// 3. Try add to cart
		$is_add_to_cart = $woocommerce->cart->add_to_cart($this->variation_id, 1, 0, array(), array (
			'start_datetime' => $this->start,
			'rent_duration' => $this->duration,
			'added_to_cart' => $this->added_time,
			'user_key' => $this->user_key,
		));
		if ( ! $is_add_to_cart ) {
			return false;
		}
		
		// 4. Set necessary cookie for order meta
		$expires_cookie = time() + (60 * (int)(get_field('booking_timer', 'options')));
		setcookie('_added_to_cart', $this->added_time, $expires_cookie, '/');
		
		// 5. Insert booking record in product
		require_once __DIR__ . '/BookingDatabase.php';
		$add_row = BookingDatabase::AddBookingRecord($this->product_id, $this->start, $this->duration, 'added',
			$this->added_time, $this->user_key);
		if ( ! $add_row ) { // If fail insert row
			error_log('No success insert booking row', 0);
		}
		
		return true;
	}
	
	/**
	 * Method clear all items from cart
	 */
	static function ClearCart($is_ajax = false) {
		if ($is_ajax === true) {
			check_ajax_referer( 'store_nonce', 'nonce' ); // Check nonce code
		}
		
		global $woocommerce;
		$woocommerce->cart->empty_cart();
		
		if ($is_ajax === true) {
			wp_die();
		}
	}
}