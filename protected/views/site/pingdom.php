<? if($this->beginCache('TCPingdomFeed', array('duration'=>1800))) { ?>
<div class="data3">
<?	
	// Create a cURL Resource
        $ch = curl_init(); 

	// Set the cURL input to be the ACU Pingdom Page
        curl_setopt($ch, CURLOPT_URL, "http://www.pingdom.com/reports/inenur7mgcn7/"); 

	// Return the output as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

   // Pipe that to a variable
        $output = curl_exec($ch); 

	// Close the resource to free up data
        curl_close($ch); 
		
	// Clean up our source code so that we remove
		$output = str_replace("<img src=\"_img/icon_up.gif\" alt=\"Up\" width=\"12\" height=\"12\" />","1",$output);
		$output = str_replace("<img src=\"_img/icon_down.gif\" alt=\"Up\" width=\"12\" height=\"12\" />","0",$output);
		
	// Load the table converter API
		Yii::import("application.extensions.tbl2array.tblConverter");
	
	// Instantiate
		$tbl = new tblConverter();
	// Pipe in the entire HTML output from the Pingdom Feed
		$tbl->source = $output;
	
		$data = $tbl->extractTable();
		
		echo "<p style='text-align:center;'>The Current Status of ACU Systems is</p>";
		echo "<center><table>\n";
		
		foreach($data as $row) {
			echo "<tr>";
			echo "<td style='padding: 5px;'>";
			if ($row['Status'] == 1)
				echo "<img src='" . Yii::app()->request->baseUrl ."/images/apply2.png' />";
			else
				echo "<img src='" . Yii::app()->request->baseUrl ."/images/cross.png' />";
			echo "</td><td style='padding-left: 15px;'><strong>" . $row['Name'] . "</strong></td>";
			echo "</tr>\n";
			}
			
		echo "</table></center>\n";
		
		?>
</div>
<? $this->endCache(); } ?>