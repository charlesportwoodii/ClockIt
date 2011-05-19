<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Messages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Manage Messages', 'url'=>array('index')),
	array('label'=>'Create New Message', 'url'=>array('create')),
);

?>

<div class="fullPage">
	<h3>Message Management</h3>
	
	<?php if(Yii::app()->user->hasFlash('success')):?>
		<div class="sucs">
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
	<?php endif; ?>
	<p class="info">
		From here you can manage all the messages stored on ShiftPlanning.
	</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'messages-grid',
	'dataProvider'=>$dataProvider,
	'columns' => array(
		'id', 
		'user', 
		'date', 
		'title', 
		'sticky',	
		array(
			'class'=>'CButtonColumn',
			'deleteButtonUrl'=>'Yii::app()->createUrl("admin/messages/delete", array("id"=>$data[\'id\']))',
			'updateButtonUrl'=>'Yii::app()->createUrl("admin/messages/update", array("id"=>$data[\'id\']))',
			'buttons'=>array(
				'view'=>array(
					'visible'=>'false'
					),
				),
			),
		),
	)
); ?>
</div>
