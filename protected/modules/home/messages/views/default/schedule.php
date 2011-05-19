<?php
$this->pageTitle=Yii::app()->name . ' - Schedule' ;
$this->breadcrumbs=array(
	'Home'=>array('../home'),
	'Schedule'
);
$this->menu=array(
	array('label'=>'Home', 'url'=>'../home'),
	array('label'=>'Change Password', 'url'=>'changepassword'),
	array('label'=>'Manage Profile', 'url'=>'update'),
	array('label'=>'Forgot to ClockIt?', 'url'=>'forgot'),
	array('label'=>'View Forgot Submissions', 'url'=>'viewforgot'),
	array('label'=>'My Schedule', 'url'=>'schedule')
	);
?>
<div class="full">
	<h3>View Schedule</h3>
	<div id='calendar'></div>
</div>
<? // Load the necessary CSS/JS Files ; ?>
<?  Yii::app()->clientScript->registerScriptfile(Yii::app()->baseUrl.'/js/jquery-1.4.4.min.js',0); ?>
<?	Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js',0); ?>
<?	Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js',0); ?>
<?	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/date.js',0); ?>
<?	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.weekcalendar.js',0); ?>
<?	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/calendar.css',0); ?>
<?	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.weekcalendar.css',0); ?>
<?	Yii::app()->clientScript->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css',0); ?>
<?  $this->renderPartial('schedule-data', NULL, false, true); ?>
