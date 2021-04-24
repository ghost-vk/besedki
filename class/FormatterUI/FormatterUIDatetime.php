<?php
namespace BESEDKA;
require_once __DIR__ . '/FormatterUI.php';

class FormatterUIDatetime extends FormatterUI {
	public function __construct($prop)
	{
		parent::__construct($prop);
	}
	
	public function Format() {
		$datetime = \DateTime::createFromFormat( 'Y-m-d H:i:s', $this->prop, new \DateTimeZone('Europe/Moscow') );
		if ( $datetime !== false ) {
			$datetime_str = $datetime->format( 'd/m в H:i' );
		}
		return $datetime_str;
	}
}