<?php
namespace BESEDKA;
require_once __DIR__ . '/DurationAvailability.php';

class DurationAvailabilityTwoHours extends DurationAvailability {
	public function __construct($start_datetime)
	{
		parent::__construct($start_datetime);
		$this->duration = '2';
		
		$data = get_field('duration_availability_group', 'options');
		$this->available_time = $data['two_hours'];
	}
}

