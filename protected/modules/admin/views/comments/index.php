<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Comments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Manage Comments', 'url'=>array('index'))
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

<?php if(Yii::app()->user->hasFlash('success')):?>
		<div class="sucs">
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
	<?php endif; ?>
	<h3>Manage Comments</h3>

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
			//'id',
			'uid',
			//'type',
			'timestamp',
			//'comment',
			'processed',
			array(
				'class'=>'CButtonColumn',
				'updateButtonUrl'=>'Yii::app()->createUrl("admin/comments/process", array("id"=>$data[\'id\']))',
				'buttons'=>array(
				'delete'=>array(
					'visible'=>'false'
					),
				),
			),
		),
	)); ?>
</div>
