<?php
$this->breadcrumbs=array(
	'Admin'=>array('../admin'),
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Users', 'url'=>array('index')),
	array('label'=>'Create New', 'url'=>array('create')),
);
?>
<div class="fullPage">
	<h3>Create Users</h3>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>