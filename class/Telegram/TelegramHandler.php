<?php
namespace Telegram\Utility;
require_once __DIR__ . '/TelegramSender.php';
require_once __DIR__ . '/TelegramMessageCreator.php';

/**
 * Class TelegramHandler
 * Used for handles creating and sending message via telegram
 * Depends on global param! (Side-effect)
 * @package Telegram\Utility
 */
class TelegramHandler {
	public $token;
	public $chat_id;
	public $message_code;
	public $args;
	
	/**
	 * TelegramHandler constructor.
	 * @param $person { String } - for whom should be send message
	 * @param $message_code { String } - message code for get message body
	 * @param $args { Array } - arguments for creates message
	 */
	public function __construct($person, $message_code, $args = null)
	{
		switch ($person) {
			case ('manager') : {
				$this->chat_id = get_field('telegram_id', 'options');
				break;
			}
			case ('tech-support') : {
				$this->chat_id = get_field('tech_support_chat_id', 'options');
				break;
			}
			default : {
				error_log('Passed wrong person type in TelegramHandler constructor');
				return;
			}
		}
		$this->message_code = $message_code;
		$this->token = '1723994804:AAF5pZxN5cZHJa9EKK2pgxv24lUiIW_-VtI';
		$this->args = $args;
	}
	
	/**
	 * Method call TelegramMessageCreator for create message
	 * then call TelegramSender for send message
	 */
	public function CallSender() {
		if ( ! $this->token || ! $this->chat_id ) {
			error_log('Haven`t success to get token or chat ID in TelegramHandler');
			return false;
		}
		$message = (new TelegramMessageCreator($this->message_code, $this->args))->GetMessage();
		if ( ! $message ) {
			return false;
		}
		
		$sender = new TelegramSender($this->token, $this->chat_id, $message);
		return $sender->Send();
	}
}