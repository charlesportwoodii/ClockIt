<table border = 1>
	<?
	if (!empty($dataReader))
	{
	
		list($year,$month,$day) = explode("-", date("Y-m-d", strtotime($dataReader[0]['shift_start'])));
		list($year1,$month1,$day1) = explode("-", date("Y-m-d", time()));

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
		$i++;
		$i--;
	
		echo "<td VALIGN = TOP>";
			foreach($dataReader as $item) {
				if ((int)date("d", strtotime($item['shift_start'])) == $i) {
					echo date("H:i", strtotime($item['shift_start'])) . '<br />';
					echo date("H:i", strtotime($item['shift_end']))  . '<br />';
					}
				else {
					echo "</td><td>";
					$i++;
					}
				}
			echo "</td>";
		
	}
?>
	</tr>
</table>
