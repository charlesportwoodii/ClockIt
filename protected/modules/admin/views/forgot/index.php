<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Forgot Management'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Manage Forgot Submissions', 'url'=>array('index')),
	array('label'=>'Create New Submission', 'url'=>array('create')),
	array('label'=>'View Schedule', 'url'=>array('/admin/schedule/viewschedule')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('comments-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="fullPage">

	<h3>Manage Forgot Submissions</h3>

	<?php if(Yii::app()->user->hasFlash('success')):?>
		<div class="sucs">
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
	<?php endif; ?>
	<p class="info">
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
	</p>

	<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
	<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'comments-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			'uid',
			'submissionTime',
			'comment',
			'type',
			array(
				'class'=>'CButtonColumn',
				'deleteConfirmation'=>"js:'The current submission will be marked as processed, and no further action will be applied to it. As a courtesy, you should leave a comment for the user before to let them know why you are refusing to apply action to this submission. Are you sure you want to continue?'",
			),
		),
	)); ?>
</div>
