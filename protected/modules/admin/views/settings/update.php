<?php
$this->breadcrumbs=array(
	'Admin'=>array('../admin'),
	'Settings'=>array('index'),
	'Update',
	$model->name
);

$this->menu=array(
	array('label'=>'Manage Settings', 'url'=>array('index')),
	array('label'=>'View Setting', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<div class="fullPage">
<h3>Update Setting: <?php echo $model->name; ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>