<?php
namespace BESEDKA;
require_once __DIR__ . '/FormatterUI.php';
require_once __DIR__ . '/FormatterUIDatetime.php';
require_once __DIR__ . '/FormatterUIDuration.php';

class FormatterUIHandler {
	public function __construct($type, $prop)
	{
		$this->type = $type;
		$this->prop = $prop;
	}
	
	public function Format() {
		switch ($this->type) {
			case ('datetime') :
				$formatter = new FormatterUIDatetime($this->prop);
				break;
			case ('duration') :
				$formatter = new FormatterUIDuration($this->prop);
				break;
			default :
				return;
		}
		
		return $formatter->Format();
	}
}