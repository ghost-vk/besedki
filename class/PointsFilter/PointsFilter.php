<?php
namespace BESEDKA;

/**
 * Class BookingFilter
 * Used for filtering booking products
 * @package BESEDKA
 */
class PointsFilter {
	private $location; // 'territory' or 'shore'
	private $min_capacity;
	private $max_capacity;
	
	
	/**
	 * BookingFilter constructor.
	 * @param $location {String|Boolean} - 'shore' or 'territory'
	 * @param $min_capacity {Integer|Boolean} - positive integer
	 * @param $max_capacity {Integer|Boolean} - positive integer
	 */
	public function __construct ( $location = false, $min_capacity = false, $max_capacity = false ) {
		if ( $location === 'shore' || $location === 'territory' ) {
			$this->location = $location;
		} else {
			$this->location = false;
		}
		
		if ( is_int($min_capacity) && $min_capacity >= 0 ) {
			$this->min_capacity = $min_capacity;
		} else {
			$this->min_capacity = false;
		}
		
		if ( is_int($max_capacity) && $max_capacity >= $min_capacity ) {
			$this->max_capacity = $max_capacity;
		} else {
			$this->max_capacity = false;
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
		
		if ( is_int($this->min_capacity) && is_int($this->max_capacity) ) {
			$args['meta_query']['capacity'] = array(
				'key' => 'capacity',
				'value' => array( $this->min_capacity, $this->max_capacity ),
				'compare' => 'BETWEEN',
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
	 * @return array|void
	 */
	public function GetFiltered() {
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
		$this->location = false;
		$this->min_capacity = false;
		return $this->GetFiltered();
	}
}