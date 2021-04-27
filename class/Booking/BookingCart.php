<?php
namespace BESEDKA;

class BookingCart {
	
	/**
	 * Method clear all items from cart
	 */
	static function ClearCart($is_ajax = false) {
		if ($is_ajax === true) {
			check_ajax_referer( 'store_nonce', 'nonce' ); // Check nonce code
		}
		
		global $woocommerce;
		$woocommerce->cart->empty_cart();
		error_log("cart was emptied");
		
		if ($is_ajax === true) {
			wp_die();
		}
	}
}