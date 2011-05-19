<? if($this->beginCache('HomeUpcommingShiftsVS', array('duration'=>1800, 'varyBySession'=>true))) { 
// Retrieve the list of upcomming shifts
		$start_date = date("Y-m-d", time());
		$end_date = date("Y-m-d", strtotime('+2 days'));
		$upcomming = $sp->getShifts( array( 'start_date' => $start_date, 'end_date' => $end_date ) );
		if ($upcomming['data'] == NULL)
			$upcomming['data'] = array();
		
		?>
<? Yii::app()->clientScript->registerCss(
	'CSSTableView',
	'.lastLine{clear:both;width:470px;border-top:1px solid #e3e7e7}#table p{float:left;clear:both;width:100%;margin:0;background:url(images/borders2.gif) 0 0 repeat-y;padding-top:5px;padding-bottom:5px}#table span{float:left;padding:0 10px;border-bottom:1px solid #e3e7e7;padding-bottom:5px}#table p.firstLine span{border-top:none}#table span.col1{width:20% }#table span.col2{width:30%}#table span.col3{width:20%}#table span.col4{width:15%}');
	?>
</style>
<div class="upcomming">
	<div id="table"> 
		<?
			foreach ($upcomming['data'] as $shift) {
				$date = DateTime::createFromFormat('m-d-Y', $shift['start_date']['month'] . "-" . $shift['start_date']['day'] . "-" . $shift['start_date']['year']);
				echo "<p><span class=\"col1\">" . $shift['schedule_name'] . "</span>";
				echo "<span class=\"col2\">" . $date->format('l, F dS, Y') . "</span>";
				echo "<span class=\"col3\">" .$shift['start_time']['time'] . " " . $shift['end_time']['time'] . "</span>";
				echo "<span class=\"col4\">&nbsp;</span></p>";
				}
		?>
	</div>
</div>
<? $this->endCache(); } ?>	
