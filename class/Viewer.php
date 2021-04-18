<?php
namespace BESEDKA;

class Viewer {
	
	public $product;
	public $id;
	public string $name;
	public int $capacity;
	public string $location;
	public array $variations;
	public array $gallery; // [ 'img_src_1', 'img_src_2', ... ]
	public $max_price;
	public $min_price;
	
	/**
	 * Viewer constructor.
	 * @method __construct
	 * @param $id
	 */
	public function __construct($id) {
		$product = wc_get_product($id);
		if (
			! $product
			OR
			! $product instanceof \WC_Product_Variable
		) {
			return false;
		}
		$this->product = $product;
		$this->id = $id;
		
		// Min and max price
		$min = (int)$product->get_variation_price('min');
		$this->min_price = number_format($min, 0, '', ' ');
		
		$max = (int)$product->get_variation_price('max');
		$this->max_price = number_format($max, 0, '', ' ');
		
		// Name
		$this->name = get_the_title($id);
		
		// Capacity
		$this->capacity = (int)get_field('capacity', $id);
		
		// Location
		$this->location = get_field('location', $id)['label'];
		
		// Variations
		$this->variations = array();
		$variations = $product->get_available_variations();
		foreach ( $variations as $variation ) {
			$variation_id = $variation['variation_id'];
			$variation_product = wc_get_product($variation_id);
			if ( ! $variation_product ) {
				continue;
			}
			
			$price_raw = (int)$variation_product->get_price();
			$price = number_format($price_raw, 0, '', ' ');
			
			$this->variations[] = array(
				'id' => $variation['variation_id'],
				'duration' => $variation['attributes']['attribute_pa_rent_duration'],
				'price' => $price,
			);
		}
		
		// Gallery
		$this->gallery = get_field('gallery', $id);
	}
}