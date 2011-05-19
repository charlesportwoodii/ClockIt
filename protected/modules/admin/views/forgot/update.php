<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Forgot Management'=>array('index'),
	'Update',
	$model->id,
);

$this->menu=array(
	array('label'=>'Manage Forgot Submissions', 'url'=>array('index')),
	array('label'=>'Create New Submission', 'url'=>array('create')),
	array('label'=>'View Schedule', 'url'=>array('/admin/schedule/viewschedule'')),
	array('label'=>'View This Submission', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<div class="fullPage">
	<h3>Process Forgot Record #<?php echo $model->id; ?> for <? echo Users::model()->getName($model->uid); ?></h3>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>