<?php
namespace BESEDKA;
require_once __DIR__ . '/DurationAvailability.php';

class DurationAvailabilityOneHour extends DurationAvailability {
	public function __construct($start_datetime)
	{
		parent::__construct($start_datetime);
		$this->duration = '1';
		
		$data = get_field('duration_availability_group', 'options');
		$this->available_time = $data['one_hour'];
	}
}

