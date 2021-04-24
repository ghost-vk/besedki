<?php
namespace BESEDKA;
require_once __DIR__ . '/DurationAvailability.php';

class DurationAvailabilityWholeDay extends DurationAvailability {
	public function __construct($start_datetime)
	{
		parent::__construct($start_datetime);
		$this->duration = 'day';
		
		$data = get_field('duration_availability_group', 'options');
		$this->available_time = $data['whole_day'];
	}
}

