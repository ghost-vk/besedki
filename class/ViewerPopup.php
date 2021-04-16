<?php
namespace BESEDKA;
require_once __DIR__ . '/Viewer.php';

class ViewerPopup extends Viewer {
	public function __construct($id)
	{
		parent::__construct($id);
	}
	
	public function get() {
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