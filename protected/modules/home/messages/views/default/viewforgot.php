<? $this->pageTitle=Yii::app()->name . ' - Forgotten Shift Status' ;
$this->breadcrumbs=array(
	'Home'=>array('../home'),
	'View Forgotten Shifts'
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
	<h3>Forgot to ClockIt Reports</h3>
	<?
		$this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'columns'=>array(
				'submissionTime',
				'start',
				'end',
				array(
					'header'=>'Processed',
					'class'=>'CButtonColumn',
					'template'=>'{yes}{no}{declined}',
					'buttons'=>array(
						'declined' => array(
							'label'=>'Declined - See Comment',
							'imageUrl'=>Yii::app()->request->baseUrl.'/images/mark.png',
							'visible'=>'$data->processed==2'
							),
						'yes' => array(
							'label'=>'Yes',
							'imageUrl'=>Yii::app()->request->baseUrl.'/images/mark.png',
							'visible'=>'$data->processed==1'
							),
						'no' => array(
							'label'=>'Pending',
							'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
							'visible'=>'$data->processed==0'
							),
						),
					),
				array(
					'header'=>'Comments',
					'class'=>'CButtonColumn',
					'template'=>'{comment}',
					'buttons'=>array(
						'comment' => array(
							'label'=>'View Comments',
							'url'=>'Yii::app()->createUrl("home/default/viewforgotcomments", array("id"=>$data->id))',
							'imageUrl'=>Yii::app()->request->baseUrl.'/images/img07.gif',
							'visible'=>'$data->comment!=NULL',

							),
						),
					),
				)
			)
		);
	?>
</div>