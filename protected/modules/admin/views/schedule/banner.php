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
	
	$dayOnTable = intval ($firstDay);

	echo "<td>";
		for($i = 0; $i < count($dataReader); $i++) {

			$shiftStart = strtotime($dataReader[$i]['shift_start']);
			$shiftEnd = strtotime($dataReader[$i]['shift_end']);

			if ((int)date("d", $shiftStart) == $dayOnTable) {
				echo date("h:i a", $shiftStart);
				echo '<br />' . date("h:i a", $shiftEnd);
			}

			for($j = $i; $j < count($dataReader); $j++) {
				$nextShiftStart = strtotime($dataReader[$i+1]['shift_start']);
				$nextShiftEnd = strtotime($dataReader[$i+1]['shift_end']);
	
				if((int)date("d", $nextShiftStart) == $dayOnTable) {			
					echo '<br /><br />';
					echo date("h:i a", $nextShiftStart);
					echo '<br />' . date("h:i a", $nextShiftEnd); 
				}
				else {
					break;
				}
			}

			echo "</td><td>";
			$dayOnTable++;
		}
?>
	</tr>
</table>
<?
	echo "<pre>";
	print_r($dataReader);
	echo "</pre>";
?>
