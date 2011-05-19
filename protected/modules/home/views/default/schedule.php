	<?php
	
// include the necessary css/js files for this view
$this->pageTitle=Yii::app()->name . ' - Schedule' ;
$this->breadcrumbs=array(
	'Home'=>array('../home'),
	'Schedule'
);
$this->menu=array(
	array('label'=>'Home', 'url'=>'../home'),
	array('label'=>'Change Password', 'url'=>'changepassword'),
	array('label'=>'Manage Profile', 'url'=>'update'),
	array('label'=>'View Forgot Submissions', 'url'=>'viewforgot'),
	array('label'=>'My Schedule', 'url'=>'schedule#calendar')
	);
?>
<div class="full">
	<a name="calendar"></a>
	<h3>View Schedule</h3>
	<div id='calendar'></div>
	<div id="event_edit_container"> 
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'forgot_form',
			'enableAjaxValidation'=>false,
		)); ?>
		
				<?php echo $form->label($model,'start'); ?>
				<?php echo $form->dropDownList($model, 'start', array(), array('name'=>'start')); ?>
					
				<?php echo $form->label($model,'end'); ?>
				<?php echo $form->dropDownList($model, 'end', array(), array('name'=>'end')); ?>
					
				<?php echo $form->labelEx($model,'type'); ?>
				<?php echo $form->radioButtonList(
					$model,
					'type',
					array(
						//1=>"System ClockOut",
						//2=>"Clocked Out Late",
						3=>"I clocked into my shift after it had already started.",
						//4=>"Forgot Entire Shift",
						),
					array(
						)
					); ?>
					
				<?php echo CHtml::label('Comments', 'Forgot_comments'); ?>
				<?php echo CHtml::textArea('Forgot_comments', 'test', array('id'=>'Forgot_comments')); ?>
			
		<?php $this->endWidget(); ?>
	</div>
</div>

<? // Ajax bPopup Box for validation stuff; ?>
	<div id="punchBox">
		<div id="loading">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif"/>
			<p>Please wait while ClockIt processes your request</p>
		</div>
	</div>
	
<?  $this->renderPartial('schedule-data', NULL, false, true); ?>
