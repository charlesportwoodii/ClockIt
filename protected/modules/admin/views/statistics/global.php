<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Statistics'=>array('index'),
	'Global Stats',
);

 Yii::app()->clientScript->registerCss(
	'CSSTableView',
	'.lastLine{clear:both;width:470px;border-top:1px solid #e3e7e7}#table p{float:left;clear:both;width:100%;margin:0;background:url(images/borders2.gif) 0 0 repeat-y;padding-top:5px;padding-bottom:5px}#table span{float:left;padding:0 10px;border-bottom:1px solid #e3e7e7;padding-bottom:5px}#table p.firstLine span{border-top:none}#table span.col1{width:40% }#table span.col2{width:20%}#table span.col3{width:20%}#table span.col4{width:15%}#table { margin-left: 10%;}');
	?>
	
	

<div class="full">
	<h3>Statistics</h3>
		<p class="info">
			The following user statistics are for the lifetime of ClockIt.
		</p>
	<div style="width: 45%; float:left;"><?
	$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
			'title' => array('text' => 'Top Absences'),
			'series' => array(
				array(
					'type' => 'pie',
					'name' => 'Pie Chart', 
					'data' => $absences,
				),
			),
			'plotOptions'=> array(
				 'pie' => array(
					'allowPointSelect' => true,
					'cursor' => 'pointer',
					'dataLabels' => array(
					   'enabled'=> false,
					   'formatter'=>'function() { return this.y;}',
					   ),
				 ),
			),
			'credits' => array('enabled' => false),
		),
	));
	?>
		<div id="table"> 

		<?
		foreach ($absences as $item) {
			echo "<p><span class=\"col1\">" . $item[0] . "</span>";
			echo "<span class=\"col2\">&nbsp;</span>";
			echo "<span class=\"col3\">" . $item[1] . "</span></p>";
			}
		?>
		</div>
	</div>

	<div style="width: 45%; float:right;"><?
	$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
			'title' => array('text' => 'Top Tardies'),
			'series' => array(
				array(
					'type' => 'pie',
					'name' => 'Pie Chart', 
					'data' => $tardies,
				),
			),
			'plotOptions'=> array(
				 'pie' => array(
					'allowPointSelect' => true,
					'cursor' => 'pointer',
					'dataLabels' => array(
					   'enabled'=> false,
					   'formatter'=>'function() { return this.y;}',
					   ),
				 ),
			),
			'credits' => array('enabled' => false),
		),
	));
	?>
		<div id="table"> 

		<?
		foreach ($tardies as $item) {
			echo "<p><span class=\"col1\">" . $item[0] . "</span>";
			echo "<span class=\"col2\">&nbsp;</span>";
			echo "<span class=\"col3\">" . $item[1] . "</span></p>";
			}
		?>
		</div>
	</div>
	<br />
	<br />
	<br />
	<div style="width: 45%; float:left;"><?
	$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
			'title' => array('text' => 'Top Forgot'),
			'series' => array(
				array(
					'type' => 'pie',
					'name' => 'Pie Chart', 
					'data' => $forgot,
				),
			),
			'plotOptions'=> array(
				 'pie' => array(
					'allowPointSelect' => true,
					'cursor' => 'pointer',
					'dataLabels' => array(
					   'enabled'=> false,
					   'formatter'=>'function() { return this.y;}',
					   ),
				 ),
			),
			'credits' => array('enabled' => false),
		),
	));
	?>
		<div id="table"> 

		<?
		foreach ($forgot as $item) {
			echo "<p><span class=\"col1\">" . $item[0] . "</span>";
			echo "<span class=\"col2\">&nbsp;</span>";
			echo "<span class=\"col3\">" . $item[1] . "</span></p>";
			}
		?>
		</div>
	</div>

	<div style="width: 45%; float:right;"><?
	$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
			'title' => array('text' => 'Top Violations'),
			'series' => array(
				array(
					'type' => 'pie',
					'name' => 'Pie Chart', 
					'data' => $violations,
				),
			),
			'plotOptions'=> array(
				 'pie' => array(
					'allowPointSelect' => true,
					'cursor' => 'pointer',
					'dataLabels' => array(
					   'enabled'=> false,
					   'formatter'=>'function() { return this.y;}',
					   ),
				 ),
			),
			'credits' => array('enabled' => false),
		),
	));
	?>
		<div id="table"> 

		<?
		foreach ($violations as $item) {
			echo "<p><span class=\"col1\">" . $item[0] . "</span>";
			echo "<span class=\"col2\">&nbsp;</span>";
			echo "<span class=\"col3\">" . $item[1] . "</span></p>";
			}
		?>
		</div>
	</div>
	<br />
	<br />
	<br />
	<div style="width: 100%;"><?
	
	$disp = array();
	
	foreach ($Karma as $i) {
		$disp[] = $i[0];
		}
	
	$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
			'title' => array('text' => 'Karma Breakdown'),			
			'yAxis' => array(
				 'title' => array('text' => 'Karma %')
				),
			'xAxis' => array(
				 'categories' => $disp,
				 'labels' => array(
					 'rotation'=> '-45',
					 'align'=>'right',
					 'style'=>array(
						 'font' => 'normal 10px Verdana, sans-serif',
						),
					),
			),
			'series' => array(
				array(
					'type' => 'column',
					'name' => 'Karma Breakdown', 
					'data' => $Karma,
					'dataLabels'=>array(
						'enabled'=>true,
						),
					),
				),
			'credits' => array('enabled' => false),
			),
		)
	);
	?>
	</div>

	
	<div style="width: 45%; float:left;">
		<div id="table"> 
		<?
		for ($i = 0; $i < 7; $i++) {
			echo "<p><span class=\"col1\">" . $Karma[$i][0] . "</span>";
			echo "<span class=\"col2\">&nbsp;</span>";
			echo "<span class=\"col3\">" . $Karma[$i][1] . "%</span></p>";
			}
		?>
		</div>
	</div>
	<div style="width: 45%; float:right;">
		<div id="table"> 
		<?
		for ($i = sizeof($Karma)-1; $i > sizeof($Karma)-8; $i--) {
			echo "<p><span class=\"col1\"> " . $Karma[$i][0] . "</span>";
			echo "<span class=\"col2\">&nbsp;</span>";
			echo "<span class=\"col3\">" . $Karma[$i][1] . "%</span></p>";
			}
		?>
		</div>
	</div>
</div>