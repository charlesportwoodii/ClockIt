<?php
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Users'=>array('index'),
	'View User',
	$model->dispName,
);

$this->menu=array(
	array('label'=>'Manage Users', 'url'=>array('index')),	
	array('label'=>'Create New User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->uid)),
	array('label'=>'View User Statistics', 'url'=>array('/admin/statistics/user/uid/' . $model->uid)),
	array('label'=>'Deactivate User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->uid),'confirm'=>'Are you sure you would like to deactivate this account?')),
);
?>

<div class="fullPage">
	<h3><?php echo $model->dispName; ?> ( <?php echo $model->uid; ?> )</h3>

	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'uid',
			'spUid',
			'email',
			//'password',
			'fName',
			'lName',
			'dispName',
			'phoneNumber',
			'address',
			'city',
			'state',
			'zip',
			'birthday',
			'active',
			'role',
	/*		'violations',
			'tardies',
			'absences',
			'forgot',
			'assists',
	*/
			'lastAttempt',
			'firstLogin',
			'numOfAttempts',
			'cStatus',
			'appToken',
		),
	)); ?>
</div>
