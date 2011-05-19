
<table border = 1>
<?
	list($year,$month,$day) = explode("-", $_REQUEST['shift_start']);
	list($year1,$month1,$day1) = explode("-", $_REQUEST['shift_end']);
			// If start month == end month, loop through from date 1 to date 2
	if ($month == $month1) { 					
		echo "<tr>";
		for ($i = $day; $i < $day1; $i++) {
			echo "<th>" . date('l M j',mktime(0, 0, 0, $month, $i, $year)) . "</th>";
			}
		echo "</tr>";					
		echo "<tr>";
		}
	else {
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$daysInMonth1 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1);
				
		echo "<tr>";
		for ($i = $day; $i <= $daysInMonth; $i++) {
			echo "<th>" . date('l M j',mktime(0, 0, 0, $month, $i, $year)) . "</th>";
			}
		for ($i = 1; $i < $day1; $i++) {
			echo "<th>" . date('l M j',mktime(0, 0, 0, $month1, $i, $year1)) . "</th>";
			}
		echo "</tr>";
		echo "<tr >";
		} 
	$i = $day;
	echo "<td VALIGN = TOP>";
		foreach($data as $item) {
			if (date("d", strtotime($item['shift_start'])) == $i) {
				echo date("d", strtotime($item['shift_start'])) . " " . $i . "<br />";
				}
			else {
				echo "</td><td>";
				$i++;
				}
			}
		echo "</td>";
?>
	</tr>
</table>
