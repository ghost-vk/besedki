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
	
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	
	if ( ! isset($name) || ! isset($phone) ) {
		wp_send_json( array('status' => false) );
		wp_die();
	}
	
	$message = 'Заказ обратного звонка:' . "\r\n\r\n";
	$message .= "Имя: $name\r\n";
	$message .= "Номер телефона: $phone";
	
	send_message_via_telegram($message);
	
	wp_send_json( array('status' => true) );
	wp_die();
}