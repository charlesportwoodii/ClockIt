<?
	
// include the necessary css/js files for this view
$this->pageTitle=Yii::app()->name . ' - Schedule' ;
$this->breadcrumbs=array(
	'Admin'=>array('admin'),
	'Shift Management'=>array('index'),
	'View Shifts'
);

$this->menu=array(
	array('label'=>'View Shifts', 'url'=>array('index')),
	array('label'=>'View Schedule', 'url'=>array('viewschedule')),
	array('label'=>'Export Shift Data', 'url'=>array('export')),
);

?>
<style>
	.floatingLink {
		position: relative;
		float:left;
		}
</style>
<div class="fullPage">
	<h3>Shift Management</h3>
	<? $this->renderPartial('_search2',array('model'=>$model)); ?>
	<br />
	<br />
	<br />
	<a href="<? echo $this->createUrl('banner', array('uid'=>$model->uid, 'shift_start'=>substr($model->shift_start,2), 'shift_end'=>substr($model->shift_end,2)), '&'); ?>" class="floatingLink">Banner view</a>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'enableSorting'=>false,
	'columns'=>array(
		array(
			'name'=>'uid',
			'value'=>'Users::getName($data->uid)',
			'filter'=>false,			
			),
		array(
			'name'=>'shift_start',
			'value'=>'date("h:i a --- l F d, Y",strtotime($data->shift_start))', 
			'filter'=>false,
			),
		array(
			'name'=>'shift_end',
			'value'=>'date("h:i a --- l F d, Y",strtotime($data->shift_end))',
			'filter'=>false,			
			),
	),
)); ?>
</div>
