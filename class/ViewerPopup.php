<?php
namespace BESEDKA;
require_once __DIR__ . '/Viewer.php';

/**
 * Class ViewerPopup
 * Used for display data in booking PopUp
 * @package BESEDKA
 */
class ViewerPopup extends Viewer {
	public array $gallery; // [ 'img_src_1', 'img_src_2', ... ]
	
	/**
	 * ViewerPopup constructor.
	 * @param $id {String|Integer}
	 */
	public function __construct($id) {
		parent::__construct($id);
		
		// Gallery
		$this->gallery = get_field('gallery', $id);
	}
	
	/**
	 * Method returns data for display
	 * @return array|false
	 */
	public function Get() {
		if ( ! $this->product ) {
			return false;
		}
		
		$popup_data = array(
			'id' => $this->id,
			'name' => $this->name,
			'capacity' => $this->capacity,
			'min' => $this->min_price,
			'max' => $this->max_price,
			'location' => $this->location,
			'variations' => $this->variations,
			'gallery' => $this->gallery,
		);
		
		return $popup_data;
	}
}