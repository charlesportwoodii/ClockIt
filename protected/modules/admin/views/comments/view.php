<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Manage Comments', 'url'=>array('index')),
);
?>
<div class="fullPage">
	<h3>View Comment #<?php echo $model->id; ?></h3>

	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			//'id',
			'uid'=>array(
				'label'=>'Submitted By',
				'name'=>'uid',
				'value'=>'blee'
				),
			//'type',
			'timestamp',
			'comment',
			'processed',
		),
	)); ?>
</div>