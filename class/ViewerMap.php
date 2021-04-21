<?php
namespace BESEDKA;

require_once __DIR__ . '/Viewer.php';

/**
 * Class ViewerMap
 * Used for getting front-end data and display on map
 * @package BESEDKA
 */
class ViewerMap extends Viewer {
	private $coordinates;
	private $preview;
	
	/**
	 * ViewerMap constructor.
	 * @param $id {String|Integer} WC_Product_Variable ID
	 */
	public function __construct($id) {
		parent::__construct($id);
		$latitude = get_field('latitude', $id);
		$longitude = get_field('longitude', $id);
		
		if ( ! $latitude || ! $longitude ) {
			return false;
		}
		
		$this->coordinates = array (
			'latitude' => $latitude,
			'longitude' => $longitude,
		);
		
		$this->preview = get_field('square_image', $this->id);
	}
	
	
	/**
	 * Method returns coordinates: ['latitude' : '41.9876', 'longitude' : '32.54321']
	 * @return array
	 */
	public function GetCoordinates() {
		return array(
			'latitude' => $this->latitude,
			'longitude' => $this->longitude,
		);
	}
	
	
	/**
	 * Get data for display on map
	 * @return array|false
	 */
	public function Get() {
		if ( ! $this->product ) {
			return false;
		}
		
		$data = array(
			'coordinates' => $this->coordinates,
			'title' => $this->name,
			'image' => $this->preview,
			'capacity' => $this->capacity,
			'min' => $this->min_price,
			'max' => $this->max_price,
			'id' => $this->id,
		);
		
		return $data;
	}
}