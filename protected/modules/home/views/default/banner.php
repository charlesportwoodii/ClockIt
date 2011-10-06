<?
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/banner.css');
?>
<h2>Clocked Times and Scheduled Times</h2>
<table border = 1>
<?
// Begin Printing Header

list($firstYear,$firstMonth,$firstDay) = explode("-", $timestamp);
$firstDay = substr($firstDay, 0, strpos($firstDay, ' '));

list($currentYear,$currentMonth,$currentDay) = explode("-", date("Y-m-d", time()));

if ($firstMonth == $currentMonth) {	
	echo "<tr>";
	for ($i = $firstDay; $i < $currentDay; $i++) {
		echo "<th>" . date('l M j',mktime(0, 0, 0, $firstMonth, $i, $firstYear)) . "</th>";
	}
	echo "</tr>";					
	echo "<tr>";
}
else {
	$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $firstMonth, $firstYear);
	$daysInFirstMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
	echo "<tr>";
	for ($i = $firstDay; $i <= $daysInCurrentMonth; $i++) {
		echo "<th>" . date('l M j',mktime(0, 0, 0, $firstMonth, $i, $firstYear)) . "</th>";
	}
	for ($i = 1; $i < $currentDay; $i++) {
		echo "<th>" . date('l M j',mktime(0, 0, 0, $currentMonth, $i, $currentYear)) . "</th>";
	}
	echo "</tr>";
	echo "<tr >";
} 

// Begin Printing Times

$NUMBER_OF_DAYS = 20;
$printer = array();
$beginning = intval ($firstDay);
$end = $beginning + $NUMBER_OF_DAYS;

for($i = $beginning; $i < $end; $i++) {
	foreach($dataReader as $j) {
		if($i == (int)date("d", strtotime($j['shift_start']))) {
			$printer[$i][] = $j;
		}
	}
}

$dayOnTable = $beginning;
foreach($printer as $day => $i) {
	echo '<td>';
	if($dayOnTable != $day) {
		// Loop through the days on the table until we find the one that matches $day
		while($dayOnTable < $end && $dayOnTable < $day) {
			echo "</td><td>";
			$dayOnTable++;
		}
	}
	foreach($i as $j) {
		$shiftStart = strtotime($j['shift_start']);
		echo date("h:i a", $shiftStart);
		echo '<br />' . date("h:i a", strtotime($j['shift_end']));
		echo '<br /><br />';
	}
	$dayOnTable++;
	echo '</td>';
}
?>
</tr>
<tr>
<?
$startDate = $timestamp;
$endDate = date("Y-m-d", time());
$scheduledShifts = $sp->getShifts(
		array(
			'mode'=>'employees',
			'employees'=>$spUid,
			'start_date' => $startDate,
			'end_date' => $endDate
		     )
		);

if($scheduledShifts['data'] != '' && $scheduledShifts['data'] != NULL) {
	unset($printer);
	$printer = array();
	for($i = $beginning; $i < $end; $i++) {
		$k = 0;
		foreach($scheduledShifts['data'] as $j) {
			if($i == $j['start_date']['day']) {
				$printer[$i][$k]['shift_start'] = $j['start_time']['time'];
				$printer[$i][$k]['shift_end'] = $j['end_time']['time'];
				$k++;
			}
		}
	}

	$dayOnTable = $beginning;
	foreach($printer as $day => $i) {
		echo '<td>';
		if($dayOnTable != $day) {
			// Loop through the days on the table until we find the one that matches $day
			while($dayOnTable < $end && $dayOnTable < $day) {
				echo "</td><td>";
				$dayOnTable++;
			}
		}
		foreach($i as $j) {
			$shiftStart = strtotime($j['shift_start']);
			echo date("h:i a", $shiftStart);
			echo '<br />' . date("h:i a", strtotime($j['shift_end']));
			echo '<br /><br />';
		}
		$dayOnTable++;
		echo '</td>';
	}
}
