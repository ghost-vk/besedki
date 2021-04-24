<?php
namespace BESEDKA;
require_once __DIR__ . '/DurationAvailability.php';

class DurationAvailabilityThreeHours extends DurationAvailability {
	public function __construct($start_datetime)
	{
		parent::__construct($start_datetime);
		$this->duration = '3';
		
		$data = get_field('duration_availability_group', 'options');
		$this->available_time = $data['three_hours'];
	}
}

