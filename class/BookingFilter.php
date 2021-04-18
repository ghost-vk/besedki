<?php
namespace BESEDKA;

/**
 * Class BookingFilter
 * Used for filtering booking products
 * @package BESEDKA
 */
class BookingFilter {
	private $location; // 'territory' or 'shore'
	private $capacity; // 5 - 150
	
	
	/**
	 * BookingFilter constructor.
	 * @param $location {String|Boolean} - 'shore' or 'territory'
	 * @param $capacity {Integer|Boolean} - more than 5
	 */
	public function __construct ( $location = false, $capacity = false ) {
		if ( $location === 'shore' || $location === 'territory' ) {
			$this->location = $location;
		} else {
			$this->location = false;
		}
		
		if ( is_int($capacity) && $capacity >= 5 ) {
			$this->capacity = $capacity;
		} else {
			$this->capacity = false;
		}
	}
	
	
	/**
	 * Get arguments for WP_Query
	 * @method GetArgs
	 * @return array
	 */
	private function GetArgs() {
		$args = array (
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'product_cat'    => 'besedki',
			'meta_query' => array(),
		);
		
		$location = $this->location;
		if ( $location === 'shore' || $location === 'territory' ) {
			$args['meta_query']['location'] = array(
				'key' => 'location',
				'value' => $location,
			);
		}
		
		$capacity = $this->capacity;
		if ( is_int($capacity) ) {
			$args['meta_query']['capacity'] = array(
				'key' => 'capacity',
				'value' => $capacity,
				'compare' => '>',
				'type' => 'NUMERIC',
			);
		}
		
		return $args;
	}
	
	
	/**
	 * @method GetIdsArray
	 * Get array of product ids from WP_Query posts
	 * @param $args {Array} for getting products (like in WP_Query)
	 * @return array
	 */
	private function GetIdsArray($args) {
		$products = get_posts($args); // Returns array of product type post
		
		$ids = array();
		if ( ! empty($products) ) {
			foreach ( $products as $product ) {
				$ids[] = $product->ID;
			}
			
		}
		
		return $ids;
	}
	
	
	/**
	 * @method GetFiltered
	 * Get filtered products ids by location and capacity - IDs array
	 * @param false $location {String|false}
	 * @param false $capacity {Integer|false}
	 * @return array|void
	 */
	public function GetFiltered($location = false, $capacity = false) {
		$this->location = $location;
		$this->capacity = $capacity;
		
		$args = $this->GetArgs();
		if ( empty($args) ) {
			return;
		}
		
		$ids = $this->GetIdsArray($args);
		return $ids;
	}
	
	
	/**
	 * @method GetAll
	 * Get all booking products - IDs array
	 * @return array
	 */
	public function GetAll() {
		return $this->GetFiltered();
	}
}