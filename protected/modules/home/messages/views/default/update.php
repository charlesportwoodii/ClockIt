<?php
$this->pageTitle=Yii::app()->name . ' - Update' ;
$this->breadcrumbs=array(
	'Home'=>array('../home'),
	'Update Profile'
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
	<h3>Update Your Profile</h3>
		<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'users-update-form',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="row">				
				<?php echo $form->error($model,'dispName'); ?>				
				<?php echo $form->error($model,'phoneNumber'); ?>			
				<?php echo $form->error($model,'birthday'); ?>			
				<?php echo $form->error($model,'address'); ?>				
				<?php echo $form->error($model,'city'); ?>				
				<?php echo $form->error($model,'state'); ?>				
				<?php echo $form->error($model,'zip'); ?>
				<?php if(Yii::app()->user->hasFlash('updateProfile')):?>
					<div class="sucs">
						<?php echo Yii::app()->user->getFlash('updateProfile'); ?>
					</div>
				<?php endif; ?>
			</div>	
			<p class="note">Fields with <span class="required">*</span> are required.</p>
			<div class="row">
				<?php echo $form->labelEx($model,'dispName'); ?>
				<?php echo $form->textField($model,'dispName'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'phoneNumber'); ?>
				<?php echo $form->textField($model,'phoneNumber'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->label($model,'birthday'); ?>
				<? $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'name'=>'Users[birthday]',
						'id'=>'Users_birthday',
						'model'=>$model,
						// additional javascript options for the date picker plugin
						'options'=>array(
							'showAnim'=>'clip',
							'dateFormat'=>'yy-mm-dd',
						),
						'htmlOptions'=>array(
							'style'=>'height:20px;'
						),
						'value'=>substr($model->birthday,0,10),
					));
					?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'address'); ?>
				<?php echo $form->textField($model,'address'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'city'); ?>
				<?php echo $form->textField($model,'city'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'state'); ?>
				<?php echo $form->textField($model,'state'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'zip'); ?>
				<?php echo $form->textField($model,'zip'); ?>
			</div>

			<div class="buttons">
				<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
			</div>

		<?php $this->endWidget(); ?>

		</div><!-- form -->
</div>