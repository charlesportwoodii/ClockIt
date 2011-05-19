<?php
$this->breadcrumbs=array(
	'Admin'=>array('../admin'),
	'Messages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Messages', 'url'=>array('index')),
	array('label'=>'Create New Message', 'url'=>array('create')),
);
?>
<div class="fullPage">
	<h3>Update Message</h3>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>