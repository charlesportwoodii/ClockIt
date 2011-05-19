<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Comments', 'url'=>array('index')),
	array('label'=>'Create Comments', 'url'=>array('create')),
	array('label'=>'View Comments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Comments', 'url'=>array('admin')),
);
?>

<div class="fullPage">
	<h3>Update Comments <?php echo $model->id; ?></h3>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>