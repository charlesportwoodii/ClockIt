<?php
$this->breadcrumbs=array(
	'Admin'=>array('../admin'),
	'Users'=>array('index'),
	$model->dispName=>array('view','id'=>$model->uid),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Users', 'url'=>array('index')),
	array('label'=>'Create New', 'url'=>array('create')),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->uid)),
	array('label'=>'View User Statistics', 'url'=>array('/admin/statistics/user/uid/' . $model->uid)),
);
?>

<div class="fullPage">
	<h3>Update <?php echo $model->dispName; ?> ( <?php echo $model->uid; ?> )</h3>
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>