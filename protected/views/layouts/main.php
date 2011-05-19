<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="description" content="Web Application" />
	<meta name="keywords" content="web, application" />
	<link rel="icon" href="favicon.ico" type="image/x-icon"> 
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<? Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/main.css'); ?>
</head>
<body>
	<div id="header">
		<h1><a href="<?php echo Yii::app()->request->baseUrl; ?>"><?php echo CHtml::encode(Yii::app()->name); ?><sup><?php echo Yii::app()->params['version']; ?></sup></a></h1>
		
		<?php 
			$module = FALSE;
			if (isset($this->module->id)) {
				$module = $this->module->getName();
				}
			$this->widget('zii.widgets.CMenu',array(
			'activeCssClass'=>'active',
			'id'=>'menu',
			'items'=>array(
				array('label'=>'Comment', 'url'=>array('/comment'), 'active'=>Yii::app()->controller->action->id=='comment'?true:false),
				array('label'=>'Home', 'url'=>array('/home'), 'active'=>$module=='home'?true:false),
				array('label'=>'Admin', 'url'=>array('/admin'), 'active'=>$module=='admin'?true:false),
			),
		)); ?>
	</div>
	<? if (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == "index") { ?>
		<div id="teaser">
			<div class="wrap">
				
				<div class="box">
					<h2><?php echo CHtml::encode(Yii::app()->name); ?></h2>
					<p>ClockIt is an automatic timeclock fully integrated into ShiftPlanning</p>
				</div>
			</div>
		</div>

		<div id="bar">
			<div class="wrap">
				<span class="step">
					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
								'links'=>$this->breadcrumbs,
								)); ?>
					<!-- breadcrumbs -->
				</span>
				<span class="step-right">
				<? if (!isset(Yii::app()->user->id)) { ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/login">Login</a>
				<? } else { ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/logout">Logout (<? echo Yii::app()->user->dispName;?>)</a>
				<? } ?>
				</span>
			</div>
		</div>
	<? } else { ?>
		<div id="teaser-small">
		</div>

		<div id="bar-small">
			<div class="wrap">
				<span class="step">
					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
								'links'=>$this->breadcrumbs,
								)); ?>
					<!-- breadcrumbs -->
				</span>
				<span class="step-right">
				<? if (!isset(Yii::app()->user->id)) { ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/login">Login</a>
				<? } else { ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/logout">Logout (<? echo Yii::app()->user->dispName;?>)</a>
				<? } ?>
				</span>
			</div>
		</div>
	<? } ?>
		<?php echo $content; ?>
	
	<div id="footer">
		<!-- <p class="right">Design: Luka Cvrk, <a title="Awsome Web Templates" href="http://www.solucija.com/">Solucija</a></p> -->
		<p>&copy; Copyright 2010 Team55 &middot; All Rights Reserved
		<span id="footer-menu">
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/comment">Comment</a> | 
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/timeclock">Timeclock</a> | 
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/home">Home</a> | 
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin">Admin</a> |
			<? if (!isset(Yii::app()->user->id)) { ?>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/login">Login</a>
			<? } else { ?>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/logout">Logout</a>
			<? } ?>
		</span>
		<br />
		Developed by <a href="mailto:charlesportwoodii@ethreal.net">Charles R. Portwood II</a> &middot; <a href="http://www.ethreal.net/">Ethreal</a>
		</p>
	</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21577234-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>
