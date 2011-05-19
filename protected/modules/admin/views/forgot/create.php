<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Forgot Management'=>array('index'),
	'Create'
);

$this->menu=array(
	array('label'=>'Manage Forgot Submissions', 'url'=>array('index')),
	array('label'=>'Create New Submission', 'url'=>array('create')),
	array('label'=>'View Schedule', 'url'=>array('/admin/schedule/viewschedule')),
);
?>

<div class="fullPage">
	<h3>Create New Forgot Record</h3>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>