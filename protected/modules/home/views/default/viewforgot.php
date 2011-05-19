<? 
// Load Client Scripts
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bPopup.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/screen2.css');

$this->pageTitle=Yii::app()->name . ' - Forgotten Shift Status' ;
$this->breadcrumbs=array(
	'Home'=>array('../home'),
	'View Forgotten Shifts'
);
$this->menu=array(
	array('label'=>'Home', 'url'=>'../home'),
	array('label'=>'Change Password', 'url'=>'changepassword'),
	array('label'=>'Manage Profile', 'url'=>'update'),
	array('label'=>'View Forgot Submissions', 'url'=>'viewforgot'),
	array('label'=>'My Schedule', 'url'=>'schedule#calendar')
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
							'click'=>'function() {
							
								// VERY tricky URL grabber
								var rx = /=(\d+)$/;
								var arr = rx.exec($(this).attr("href"));
								
								$.ajax({
									url: "viewforgotcomments",
									type: "POST",
									data: {"id": arr[1]},
									beforeSend: function() {
										$("#punchBox").bPopup({modalClose: true, escClose: true, vStart: 150});
										},
									success: function(data) {
										// Close our Dialog box if successful, otherwise we need to keep it open
										$("#loading").replaceWith("<div id=\"loading\"><strong>" + data + "</strong></div>");
										},
									error: function(data) {
										// Yii error ouput for errors
										$("#loading").replaceWith("<div id=\"loading\"><strong>You are not permitted to view this comment.</strong></div>");
										},
									complete: function() {					
										}
						});
						return false;
								}',
							),
						),
					),
				)
			)
		);
	?>
</div>

<? // Ajax bPopup Box for validation stuff; ?>
	<div id="punchBox">
		<div id="loading">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif"/>
			<p>Please wait while ClockIt processes your request</p>
		</div>
	</div>