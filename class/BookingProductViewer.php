<?php
namespace BESEDKA;

class BookingProductViewer {
	
	private $product;
	private $id;
	private string $name;
	private int $capacity;
	private string $location;
	private array $variations;
	private array $gallery;
	
	
	/**
	 * BookingProductViewer constructor.
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
			
			$this->variations[] = array(
				'id' => $variation['variation_id'],
				'duration' => $variation['attributes']['attribute_pa_rent_duration'],
				'price' => $variation_product->get_price(),
			);
		}
		
		// Gallery
		$this->gallery = get_field('gallery', $id);
	}
	
	
	public function GetCoordinates() {}
	
	
	/**
	 * Get necessary data for display in modal window
	 * @return array|false
	 */
	public function GetPopupData() {
		if ( ! $this->product ) {
			return false;
		}
		
		$popup_data = array(
			'id' => $this->id,
			'name' => $this->name,
			'capacity' => $this->capacity,
			'location' => $this->location,
			'variations' => $this->variations,
			'gallery' => $this->gallery,
		);
		
		return $popup_data;
	}
}