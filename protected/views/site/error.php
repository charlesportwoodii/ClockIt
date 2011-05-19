<?php
$this->pageTitle=Yii::app()->name . ' - ' . $code ;
$this->breadcrumbs=array(
	'Error',
);
?>
		<h3>Error <?php echo $code; ?></h3>
		<div class="err">
			<?php echo CHtml::encode($message); ?>
		</div>
		<br />
		<br />