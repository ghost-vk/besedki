<?php
/**
* Detect mobile users
* @return false|int
*/
function is_mobile() {
	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


/**
 * Sends message via telegram.
 * @param $message {String} - should be sended to manager
 */
function send_message_via_telegram($message) {
	if ( !isset($message) ) {
		return;
	}
	$chat_id = get_field('telegram_id', 'options'); // Get chat ID from admin settings
	
	$token = '1723994804:AAF5pZxN5cZHJa9EKK2pgxv24lUiIW_-VtI';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,
		'https://api.telegram.org/bot'.$token.'/sendMessage');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
		'chat_id=' . $chat_id . '&text=' . urlencode($message));
	$result = curl_exec($ch);
	curl_close($ch);
}

add_filter( 'woocommerce_order_button_text', 'change_checkout_btn_text' );
function change_checkout_btn_text( $button_text ) {
	return 'Оплатить';
}


/**
 * Create user key
 * Store it in COOKIE
 */
add_action ( 'store_user_key_in_cookie', 'store_user_key_in_cookie', 10, 0 );
function store_user_key_in_cookie () {
	if ( ! isset($_COOKIE['user_key']) ) {
		$now_datetime = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
		$now_str = $now_datetime->format('YmdHis');
		$user_key = md5($now_str);
		setcookie('user_key', $user_key, time() + 3600 * 24, '/', '', 0);
	}
}


/**
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support( 'title-tag' );

/**
 * Changes shop title
 */
add_filter( 'document_title_parts', 'wc_custom_shop_archive_title' );
function wc_custom_shop_archive_title( $title ) {
	if ( is_shop() && isset( $title['title'] ) ) {
		$title['title'] = 'Бронирование';
	}
	
	return $title;
}

/**
 * Set SMTP
 * @param PHPMailer $phpmailer
 */
use PHPMailer\PHPMailer\PHPMailer;
add_action( 'phpmailer_init', 'init_smtp_constants' );
function init_smtp_constants( PHPMailer $phpmailer ) {
	if ( defined('SMTP_USER') && defined('SMTP_PASS') ) {
		$phpmailer->isSMTP();
		$phpmailer->Host       = SMTP_HOST;
		$phpmailer->SMTPAuth   = SMTP_AUTH;
		$phpmailer->Port       = SMTP_PORT;
		$phpmailer->Username   = SMTP_USER;
		$phpmailer->Password   = SMTP_PASS;
		$phpmailer->SMTPSecure = SMTP_SECURE;
		$phpmailer->From       = SMTP_FROM;
		$phpmailer->FromName   = SMTP_NAME;
	}
}