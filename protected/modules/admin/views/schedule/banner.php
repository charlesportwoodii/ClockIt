<?
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/banner.css');
?>

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
	if($dayOnTable == $day) {
		echo "if";
		foreach($i as $j) {
			$shiftStart = strtotime($j['shift_start']);
			echo date("h:i a", $shiftStart);
			echo '<br />' . date("h:i a", strtotime($j['shift_end']));
			echo '<br /><br />';
		}
		$dayOnTable++;
	}
	else {
		echo "else";
		// Loop through the days on the table until we find the one that matches $day
		while($dayOnTable < $end && $dayOnTable < $day) {
			echo "</td><td>";
			$dayOnTable++;
		}
	}
	echo '</td>';
}

//	echo "<td>";
//		for($i = 0; $i < count($dataReader); $i++) {
//
//			$shiftStart = strtotime($dataReader[$i]['shift_start']);
//			$shiftEnd = strtotime($dataReader[$i]['shift_end']);
//			for($k = $dayOnTable; $k < $firstDay + $NUMBER_OF_DAYS; $k++) {
//				$dayOfCurrentShift = (int)date("d", $shiftStart);
//				if ($dayOfCurrentShift == $k) {
//					echo date("h:i a", $shiftStart);
//					echo '<br />' . date("h:i a", $shiftEnd);
//					for($j = $i + 1; $j < count($dataReader); $j++) {
//						$nextShiftStart = strtotime($dataReader[$j]['shift_start']);
//						$nextShiftEnd = strtotime($dataReader[$j]['shift_end']);
//			
//						if((int)date("d", $nextShiftStart) == $k) {			
//							echo '<br /><br />';
//							echo date("h:i a", $nextShiftStart);
//							echo '<br />' . date("h:i a", $nextShiftEnd); 
//						}
//						else {
//							$i = $j - 1;
//							break;
//						}
//					}
//				}
//				else if($k < (int)date("d", strtotime($dataReader[$i]['shift_start']))) {
//					echo '</td><td>';
//				}
//				else {
//					break;
//				}
//			}
//
//			echo "</td><td>";
//			$dayOnTable++;
//		}
?>
</tr>
</table>
<?
echo "<pre>";
print_r($printer);
print_r($dataReader);
echo "</pre>";
?>
