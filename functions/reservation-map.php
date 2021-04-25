<?php
/**
 * Function returns data for display map points after loading map
 * @return array
 */
function get_default_points_data() {
	require_once __DIR__ . '/../class/Viewer/ViewerMap.php';
	require_once __DIR__ . '/../class/PointsFilter/PointsFilter.php';
	
	$data = array();
	$_bf = new BESEDKA\PointsFilter();
	$products = $_bf->GetAll();
	foreach ( $products as $id ) {
		$point = new BESEDKA\ViewerMap($id);
		$data[] = $point->Get();
	}
	
	return $data;
}


if ( wp_doing_ajax() ) {
	// Get filtered map points
	add_action( 'wp_ajax_get_updates_points_data', 'get_updates_points_data' );
	add_action( 'wp_ajax_nopriv_get_updates_points_data', 'get_updates_points_data' );
}

function get_updates_points_data() {
	check_ajax_referer( 'store_nonce', 'nonce' ); // Check nonce code
	
	$capacity = $_POST['capacity'];
	$location = $_POST['location'];
	
	if ( ! isset($capacity) || ! isset($location) ) {
		wp_send_json(array( "status" => false ));
		wp_die();
	}
	
	if ( ! is_int($capacity) ) {
		$capacity = (int)$capacity;
	}
	
	
	require_once __DIR__ . '/../class/PointsFilter/PointsFilter.php';
	require_once __DIR__ . '/../class/Viewer/ViewerMap.php';
	
	$location = ("no-matter" === $location) ? false : $location;
	$capacity = ("no-matter" === $capacity) ? false : $capacity;
	
	$_bf = new BESEDKA\PointsFilter($location, $capacity);
	$products = $_bf->GetFiltered();
	
	$data = array();
	foreach ( $products as $id ) {
		$point = new BESEDKA\ViewerMap($id);
		$data[] = $point->Get();
	}
	
	$response = array(
		"status" => ( empty($data) ) ? false : true,
		"points" => $data,
	);
	
	wp_send_json($response);
	wp_die();
}