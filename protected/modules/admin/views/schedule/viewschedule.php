<?php
	
// include the necessary css/js files for this view
$this->pageTitle=Yii::app()->name . ' - Admin | Schedule' ;
$this->breadcrumbs=array(
	'Admin'=>array('admin'),
	'Shift Management'=>array('index'),
	'View Schedule'
);
?>
<div class="full">
	<a name="calendar"></a>
	<h3>View Schedule</h3>
	<p class="info">From this form, you can add and edit shifts for any given user. Changes made via this form are filed as <i>forgot to clock it</i> notices.
	<br />
	This interface is <i><strong>strickly</strong></i> for filing new or unfiled forgot report, and should not be used to process current forgot reports. To manage forgotten shifts, use the <a href="<? echo $this->createUrl('/admin/forgot'); ?>">forgotten shift manager</a>.</p>
	<? $this->renderPartial('_search',array('model'=>$model)); ?>
	<br /><br />
	<a href="<? echo $this->createUrl('banner?uid=' . $_POST['Users']['uid']); ?>" class="floatingLink">Banner view</a>
	<a href="<? echo $this->createUrl('export?uid=' . $_POST['Users']['uid']); ?>" class="floatingLink">Export</a>
	<br /><br />
	<div id='calendar'></div>
</div>

<? // Ajax bPopup Box for validation stuff; ?>
	<div id="punchBox">
		<div id="loading">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif"/>
			<p>Please wait while ClockIt processes your request</p>
		</div>
	</div>
	<div id="event_edit_container"> 
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'forgot_form',
			'enableAjaxValidation'=>false,
		)); ?>
			<p class="info">This will file a forgot report for this shift.</p>
				<?php echo $form->label($forgot,'start'); ?>
				<?php echo $form->dropDownList($forgot, 'start', array(), array('name'=>'start')); ?>
					
				<?php echo $form->label($forgot,'end'); ?>
				<?php echo $form->dropDownList($forgot, 'end', array(), array('name'=>'end')); ?>
					
				<?php echo CHtml::label('Comments', 'Forgot_comments'); ?>
				<?php echo CHtml::textArea('Forgot_comments', '', array('id'=>'Forgot_comments')); ?>
			
		<?php $this->endWidget(); ?>
	</div>

	
<?  $this->renderPartial('schedule-data', array('spUid'=>$model->spUid, 'uid'=>$model->uid), false, true); ?>
