<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Statistics'=>array('index'),
	'Forgot	Stats',
);

 Yii::app()->clientScript->registerCss(
	'CSSTableView',
	'.lastLine{clear:both;width:470px;border-top:1px solid #e3e7e7}#table p{float:left;clear:both;width:100%;margin:0;background:url(images/borders2.gif) 0 0 repeat-y;padding-top:5px;padding-bottom:5px}#table span{float:left;padding:0 10px;border-bottom:1px solid #e3e7e7;padding-bottom:5px}#table p.firstLine span{border-top:none}#table span.col1{width:40% }#table span.col2{width:20%}#table span.col3{width:20%}#table span.col4{width:15%}#table { margin-left: 10%;}');
	?>
	
<div class="full">
	<h3>Forgot Submissions</h3>
	<?	$this->renderPartial('_search', array('timestamp'=>$timestamp), false, false); ?>
	<br /><br />
	<div style="width: 50%; float:left;"><?
	$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
			'title' => array('text' => 'Submission Breakdown for ' .date("M Y", strtotime($timestamp))),
			'series' => array(
				array(
					'type' => 'pie',
					'name' => 'Pie Chart', 
					'data' => $time,
				),
			),
			'plotOptions'=> array(
				 'pie' => array(
					'allowPointSelect' => true,
					'cursor' => 'pointer',
					'dataLabels' => array(
					   'enabled'=> true,
					   ),
				 ),
			),
			'credits' => array('enabled' => false),
		),
	));
	?>
	</div>

	<div style="width: 50%; float:right;"><?
	$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
			'title' => array('text' => 'Total Submission Breakdown'),
			'series' => array(
				array(
					'type' => 'pie',
					'name' => 'Pie Chart', 
					'data' => $overall,
				),
			),
			'plotOptions'=> array(
				 'pie' => array(
					'allowPointSelect' => true,
					'cursor' => 'pointer',
					'dataLabels' => array(
					   'enabled'=> true,
					   ),
				 ),
			),
			'credits' => array('enabled' => false),
		),
	));
	?>
	</div>
</div>