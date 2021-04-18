<?php
/**
 * Function returns data for display map points after loading map
 * @return array
 */
function get_default_points_data() {
	require_once __DIR__ . '/../class/ViewerMap.php';
	require_once __DIR__ . '/../class/BookingFilter.php';
	
	$data = array();
	$_bf = new BESEDKA\BookingFilter();
	$products = $_bf->GetAll();
	foreach ( $products as $id ) {
		$point = new BESEDKA\ViewerMap($id);
		$data[] = $point->Get();
	}
	
	return $data;
}