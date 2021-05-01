<?php
if ( wp_doing_ajax() ) {
	// Get callback lid
	add_action( 'wp_ajax_callback_lid', 'get_callback_lid' );
	add_action( 'wp_ajax_nopriv_callback_lid', 'get_callback_lid' );
}

/**
 * Function sends message with lid data via AJAX
 * @param $_POST['name'] { 'Анастасия' }
 * @param $_POST['phone'] { '8 (999) 888-77-66' }
 * @returns JSON { 'status' : true }
 */
function get_callback_lid () {
	check_ajax_referer( 'store_nonce', 'nonce' ); // Check nonce code
	
	$args = array(
		'name' => $_POST['name'],
		'phone' => $_POST['phone'],
	);
	
	require_once __DIR__ . '/../class/Telegram/TelegramHandler.php';
	$_th = new Telegram\Utility\TelegramHandler('manager', 'get-lid-callback', $args);
	$is_send = $_th->CallSender();
	
	wp_send_json( array('status' => $is_send) );
	wp_die();
}