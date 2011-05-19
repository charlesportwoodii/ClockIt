<?php
$this->breadcrumbs=array(
	'Admin'=>array('../admin'),
	'System Log'=>array('index'),
	'View',
	$model->wid,
);

$this->menu=array(
	array('label'=>'Manage Logs', 'url'=>array('index')),
);
?>

<div class="fullPage">
<h3>View Log Entry #<?php echo $model->wid; ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'wid',
		'timestamp',
		'ipAddress',
		'type',
		'data',
	),
)); ?>
</div>
