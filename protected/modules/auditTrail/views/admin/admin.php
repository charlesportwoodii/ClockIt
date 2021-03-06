<?php
$this->breadcrumbs=array(
	'Admin'=>array('/auditTrail'),
	'Logs',
);

$this->menu=array(
	array('label'=>'Manage Log Entries', 'url'=>array('/admin/logs')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('audit-trail-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="fullPage">
	<h3>System Logging</h3>

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
	
	<br />
	<br />
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'audit-trail-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			//'id',
			'old_value',
			'new_value',
			'action',
			'model',
			'field',
			//'stamp',
			'user_id',
			/*
			'model_id',
			*/
			array(
				'class'=>'CButtonColumn',
			),
		),
	)); ?>
</div>