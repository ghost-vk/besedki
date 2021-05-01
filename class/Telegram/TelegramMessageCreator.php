<?php
namespace Telegram\Utility;

class TelegramMessageCreator {
	public $message_code;
	public $args;
	
	/**
	 * TelegramMessageCreator constructor.
	 * @param $message_code { String } message code to get message body
	 * @param $args { Array | null } arguments for creating message
	 */
	public function __construct($message_code, $args)
	{
		if ( ! isset($message_code) ) {
			return;
		}
		$this->message_code = $message_code;
		$this->args = $args;
	}
	
	/**
	 * Method get message
	 */
	public function GetMessage() {
		switch ($this->message_code) {
			case ('error-change-booking-status') : {
				return $this->GetErrorChangeBookingStatusMessage();
			}
			case ('get-lid-callback') : {
				return $this->GetLidCallbackMessage();
			}
			case ('error-no-cookie-creating-order') : {
				return $this->GetErrorNoCookieCreatingOrderMessage();
			}
			default : {
				error_log('Haven`t success for creating message in TelegramMessageCreator method GetMessage');
				return false;
			}
		}
	}
	
	/**
	 * Method creates message for case when fail to update booking status
	 */
	public function GetErrorChangeBookingStatusMessage () {
		$product_name = ( ! empty($this->args['product_name']) ) ? $this->args['product_name'] : '???';
		$message = 'Ошибка на сайте:' . "\r\n\r\n";
		$message .= "Не удалось изменить статус бронирования в товаре: `$product_name` \r\n";
		
		return $message;
	}
	
	/**
	 * Method creates message for case when user fill callback form
	 */
	public function GetLidCallbackMessage () {
		if ( ! isset($this->args['name']) || ! isset($this->args['phone']) ) {
			return false;
		}
		
		$name = $this->args['name'];
		$phone = $this->args['phone'];
		
		$message = 'Заказ обратного звонка:' . "\r\n\r\n";
		$message .= "Имя: $name\r\n";
		$message .= "Номер телефона: $phone";
		
		return $message;
	}
	
	/**
	 * Method returns message for case when have no necessary cookies in creating order
	 */
	public function GetErrorNoCookieCreatingOrderMessage() {
		$message = 'Ошибка на сайте:' . "\r\n\r\n";
		$message .= "Не установлены необходимые cookie файлы в функции\r\n";
		$message .= "`before_checkout_create_order`";
		
		return $message;
	}
}