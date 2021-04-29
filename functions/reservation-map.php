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
	
	$location = ("no-matter" === $_POST['location']) ? false : $_POST['location'];
	$capacity = ("no-matter" === $_POST['capacity']) ? false : $_POST['capacity'];
	
	if ( ! isset($capacity) || ! isset($location) ) {
		error_log('Not set capacity in ajax function: `get_updates_points_data`');
		wp_send_json(array( "status" => false ));
		wp_die();
	}
	
	if ( $capacity !== false ) {
		$capacity_array = explode('#', $capacity, 2);
		if ( count($capacity_array) !== 2 ) {
			error_log('Wrong param capacity in ajax function: `get_updates_points_data`');
			wp_send_json(array( "status" => false ));
			wp_die();
		}
		$min_capacity = (int)$capacity_array[0];
		$max_capacity = (int)$capacity_array[1];
	} else {
		$min_capacity = false;
		$max_capacity = false;
	}
	
	require_once __DIR__ . '/../class/PointsFilter/PointsFilter.php';
	require_once __DIR__ . '/../class/Viewer/ViewerMap.php';
	
	$filter = new BESEDKA\PointsFilter($location, $min_capacity, $max_capacity);
	$products = $filter->GetFiltered();
	
	$data = array();
	foreach ( $products as $id ) {
		$data[] = (new BESEDKA\ViewerMap($id))->Get();
	}
	
	$response = array(
		"status" => ( empty($data) ) ? false : true,
		"points" => $data,
	);
	
	wp_send_json($response);
	wp_die();
}