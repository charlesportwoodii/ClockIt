<? $this->pageTitle=Yii::app()->name . ' - Forgotten Shift Status' ;
$this->breadcrumbs=array(
	'Home'=>array('../home'),
	'Forgot Comments'=>array('viewforgot'),
	'Submission ' . $_GET['id']
);
$this->menu=array(
	array('label'=>'Home', 'url'=>'../home'),
	array('label'=>'Change Password', 'url'=>'changepassword'),
	array('label'=>'Manage Profile', 'url'=>'update'),
	array('label'=>'Forgot to ClockIt?', 'url'=>'forgot'),
	array('label'=>'View Forgot Submissions', 'url'=>'viewforgot'),
	array('label'=>'My Schedule', 'url'=>'schedule')
	);
?>
<div class="fullPage">
	<h3>Forgot to ClockIt Comments &raquo; <? echo $_GET['id']; ?></h3>
	
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_vcf',
			)
		);
	?>
</div>