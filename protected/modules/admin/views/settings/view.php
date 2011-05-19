<?php
$this->breadcrumbs=array(
	'Admin'=>array('../admin'),
	'Settings'=>array('index'),
	'View',
	$model->name
);

$this->menu=array(
	array('label'=>'Manage Settings', 'url'=>array('index')),
	array('label'=>'Update Setting', 'url'=>array('update', 'id'=>$model->id)),
);
?>

<div class="fullPage">
<h3>View Setting: <?php echo $model->name; ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'name',
		'value',
		'info',
	),
)); ?>
</div>
