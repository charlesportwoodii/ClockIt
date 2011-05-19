<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Forgot Management'=>array('index'),
	'View'
);

$this->menu=array(
	array('label'=>'Manage Forgot Submissions', 'url'=>array('index')),
	array('label'=>'Create New Submission', 'url'=>array('create')),
	array('label'=>'View Schedule', 'url'=>array('/admin/schedule/viewschedule')),
	array('label'=>'Update Submission', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Mark as Processed', 'url'=>array('delete', 'id'=>$model->id)),
);
?>

<?

	if ($model->flag == 1)
		$processed = "Pending";
	else if ($model->processed == 0)
		$processed = "No";
	else
		$processed = "Yes";
?>
<div class="fullPage">
	<h3>View Forgot Submission #<?php echo $model->id; ?></h3>

	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			//'id',
			array(
				'label'=>'User',
				'value'=>Users::model()->getName($model->uid),
				),
			//'asid',
			array(
				'label'=>'Submission Time',
				'value'=>date("M d, Y h:i", strtotime($model->submissionTime)),
				),
			array(
				'label'=>'Reported Start Time',
				'value'=>date("M d, Y h:i", strtotime($model->start)),
				),
			array(
				'label'=>'Reported End Time',
				'value'=>date("M d, Y h:i", strtotime($model->end)),
				),
			array(
				'label'=>'Type',
				'value'=>$type,
				),
			array(
				'label'=>'Processed',
				'value'=>$processed,
				),
			'comment',
			//'data',
		),
	)); ?>
</div>
