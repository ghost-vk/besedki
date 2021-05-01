<?php
namespace Telegram\Utility;

/**
 * Class TelegramSender
 * Used for sending messages
 * @package Telegram\Utility
 */
class TelegramSender {
	public $token; // bot token
	public $chat_id;
	public $message;
	
	/**
	 * TelegramMessage constructor.
	 * @param $token { String }
	 * @param $chat_id { String }
	 */
	public function __construct($token, $chat_id, $message)
	{
		if ( ! isset($token) || ! isset($chat_id) && ! isset($message) ) {
			return;
		}
		$this->token = $token;
		$this->chat_id = $chat_id;
		$this->message = $message;
	}
	
	/**
	 * Method send message via curl to telegram api
	 */
	public function Send() {
		if ( ! isset($this->message) ) {
			return false;
		}
		$chat_id = $this->chat_id;
		$token = $this->token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,
			'https://api.telegram.org/bot'.$token.'/sendMessage');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
			'chat_id=' . $chat_id . '&text=' . urlencode($this->message));
		$result = curl_exec($ch);
		curl_close($ch);
		
		return true;
	}
}