<?
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/banner.css');
?>
<h2>Clocked Times</h2>
<table border = 1>
<?
// Begin Printing Header

list($firstYear,$firstMonth,$firstDay) = explode("-", date("Y-m-d", strtotime($dataReader[0]['shift_start'])));
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
$scheduledShifts = $sp->getShifts(array( 'start_date' => $firstDay, 'end_date' => $end) );

echo '<pre';
print_r($scheduledShifts);
echo '</pre>';
?>
