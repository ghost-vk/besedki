<?php
namespace BESEDKA;
require_once __DIR__ . '/FormatterUI.php';

class FormatterUIDuration extends FormatterUI {
	public function __construct($prop)
	{
		parent::__construct($prop);
	}
	
	public function Format() {
		switch ($this->prop) {
			case '1':
				$duration = '1 час';
				break;
			case '2':
				$duration = '2 часа';
				break;
			case '3':
				$duration = '3 часа';
				break;
			case 'day':
				$duration = 'Целый день';
				break;
			default:
				$duration = $this->prop;
				break;
		}
		
		return $duration;
	}
}