<?php
if ( wp_doing_ajax() ) {
	// Get callback lid
	add_action( 'wp_ajax_callback_lid', 'get_callback_lid' );
	add_action( 'wp_ajax_nopriv_callback_lid', 'get_callback_lid' );
}

/**
 * Get data from POST data after
 * Constructs message
 * Send to telegram chat
 */
function get_callback_lid () {
	check_ajax_referer( 'callback_nonce', 'nonce' ); // Check nonce code
	
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	
	if ( !isset($name) || !isset($phone) ) {
		return;
	}
	
	$message = 'Заказ обратного звонка:' . "\r\n\r\n";
	$message .= "Имя: $name\r\n";
	$message .= "Номер телефона: $phone";
	
	send_message_via_telegram($message);
	
	wp_die();
}