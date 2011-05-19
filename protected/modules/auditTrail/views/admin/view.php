<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Users'=>array('index'),
	'View User',
	$model->dispName,
);

$this->menu=array(
	array('label'=>'Manage Users', 'url'=>array('index')),	
	array('label'=>'Create New User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->uid)),
	array('label'=>'Deactivate User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->uid),'confirm'=>'Are you sure you would like to deactivate this account?')),
);
?>

<div class="fullPage">
	<h3><?php echo $model->dispName; ?> ( <?php echo $model->uid; ?> )</h3>

	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			//'id',
			'old_value',
			'new_value',
			'action',
			'model',
			'field',
			'stamp',
			'user_id',
			'model_id',
		),
	)); ?>
</div>
