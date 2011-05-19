<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Statistics'=>array('index'),
	'User	Stats',
);

 Yii::app()->clientScript->registerCss(
	'CSSTableView',
	'.lastLine{clear:both;width:470px;border-top:1px solid #e3e7e7}#table p{float:left;clear:both;width:100%;margin:0;background:url(images/borders2.gif) 0 0 repeat-y;padding-top:5px;padding-bottom:5px}#table span{float:left;padding:0 10px;border-bottom:1px solid #e3e7e7;padding-bottom:5px}#table p.firstLine span{border-top:none}#table span.col1{width:30% }#table span.col2{width:10%}#table span.col3{width:20%}#table span.col4{width:15%}#table { margin-left: 15%; }');
	?>
	
<div class="full">
	<h3>Statistics for <? echo Users::getName($model->uid); ?></h3>
	<?	$this->renderPartial('_search2', array('timestamp'=>$timestamp, 'model'=>$model), false, false); ?>
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
	<div style="width: 50%; float:right;">
		<h3><center>User Totals</center></h3>
		<div id="table">
			<p><span class="col1">Violations: </span>
			   <span class="col2">&nbsp;</span>
			   <span class="col3"><? echo $user[0]['violations']; ?></span>
			</p>
			<p><span class="col1">Tardies: </span>
			   <span class="col2">&nbsp;</span>
			   <span class="col3"><? echo $user[0]['tardies']; ?></span>
			</p>
			<p><span class="col1">Absences: </span>
			   <span class="col2">&nbsp;</span>
			   <span class="col3"><? echo $user[0]['absences']; ?></span>
			</p>
			<p><span class="col1">Forgot: </span>
			   <span class="col2">&nbsp;</span>
			   <span class="col3"><? echo $user[0]['forgot']; ?></span>
			</p>
			<p><span class="col1">Assists: </span>
			   <span class="col2">&nbsp;</span>
			   <span class="col3"><? echo $user[0]['assists']; ?></span>
			</p>
			<p><span class="col1">Karma: </span>
			   <span class="col2">&nbsp;</span>
			   <span class="col3"><? echo (100- $user[0]['absences'] * 5 - $user[0]['tardies'] * 3 - $user[0]['violations'] * 2 - $user[0]['forgot']); ?></span>
			</p>
		</div>
	</div>
</div>