<?php
$this->breadcrumbs=array(
	'Admin'=>array('../admin'),
	'Settings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Manage Settings', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('server-variables-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="fullPage">
<h3>Manage Settings</h3>

<?php if(Yii::app()->user->hasFlash('success')):?>
		<div class="sucs">
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
	<?php endif; ?>
<p class="info">
From this menu you can modify Clockit's core settings.
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'server-variables-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'name',
		//'value',
		'info',
		array(
			'class'=>'CButtonColumn',
			'buttons'=>array(
				'delete'=>array(
					'visible'=>'false'
					),
				),
		),
	),
)); ?>
</div>