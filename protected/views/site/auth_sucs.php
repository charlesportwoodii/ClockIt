<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
		<div id="full">
			<h2>Authentication Sucessful</h2>
			<center>
			<p>You have sucessfully linked your accout to Shift Planning. Before you can continue, please login with your new credentials.</p>	
			<? Yii::app()->apccache->flush(); ?>
			</center>
		</div>