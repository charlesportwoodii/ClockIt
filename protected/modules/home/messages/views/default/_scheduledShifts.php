<? if($this->beginCache('viewSchedule', array('duration'=>1800, 'varyBySession'=>true))) { 
		$start_date = date("Y-m-d", strtotime('-30 days'));
		$end_date = date("Y-m-d", strtotime('+30 days'));
		$shifts = $sp->getShifts( array( 'start_date' => $start_date, 'end_date' => $end_date ) );
?>

[
<?	
	foreach ($dataProvider->data as $data) {
		echo "{";
		echo '"id":' . $data->pid . ",";
        echo '"start":"' . date("c", strtotime($data->shift_start)) . "\",";
        echo '"end":"'   . date("c", strtotime($data->shift_end)) . "\",";
		echo '"title":"Clocked Time"';
		echo "},";
			} 
	$i = 0;
	foreach ($shifts['data'] as $shift) {
		$start_timestamp = DateTime::createFromFormat('m-d-Y H:i', $shift['start_date']['month'] . "-" . $shift['start_date']['day'] . "-" . $shift['start_date']['year'] . " " . date("H:i", strtotime($shift['start_time']['time'])));
		$end_timestamp = DateTime::createFromFormat('m-d-Y H:i', $shift['end_date']['month'] . "-" . $shift['end_date']['day'] . "-" . $shift['end_date']['year'] . " " . date("H:i", strtotime($shift['end_time']['time'])));
		
		echo "{";
		echo '"id":' . $shift['id'] . ",";
        echo '"start":"' . $start_timestamp->format('c') . "\",";
        echo '"end":"'   . $end_timestamp->format('c') . "\",";
		echo '"title":"' . $shift['schedule_name'] . '"';
		if (sizeof($shifts['data']) == ++$i)
			echo "}";
		else
			echo "},";
	}
	?>
	]
<?  $this->endCache(); } ?>	