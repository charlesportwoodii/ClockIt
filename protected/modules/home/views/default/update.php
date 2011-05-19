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
	array('label'=>'View Forgot Submissions', 'url'=>'viewforgot'),
	array('label'=>'My Schedule', 'url'=>'schedule#calendar')
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
			<center>
			<table>
				<tr>
					<td><?php echo $form->labelEx($model,'dispName'); ?></td>
					<td><?php echo $form->textField($model,'dispName'); ?></td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model,'phoneNumber'); ?></td>
					<td><?php echo $form->textField($model,'phoneNumber'); ?></td>
				</tr>
				<tr>
					<td><?php echo $form->label($model,'birthday'); ?></td>
					<td><? $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'name'=>'Users[birthday]',
						'id'=>'Users_birthday',
						'model'=>$model,
						// additional javascript options for the date picker plugin
						'options'=>array(
							'showAnim'=>'clip',
							'dateFormat'=>'yy-mm-dd',
							'changeYear'=>true,
						),
						'htmlOptions'=>array(
							'style'=>'height:20px;'
						),
						'value'=>substr($model->birthday,0,10),
					));
					?></td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model,'address'); ?></td>
					<td><?php echo $form->textField($model,'address'); ?></td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model,'city'); ?></td>
					<td><?php echo $form->textField($model,'city'); ?></td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model,'state'); ?></td>
					<td><?php echo $form->textField($model,'state'); ?></td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model,'zip'); ?></td>
					<td><?php echo $form->textField($model,'zip'); ?></td>
				</tr>
			</table>
			<div class="buttons">
				<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
			</div>

		<?php $this->endWidget(); ?>
		</center>
		</div><!-- form -->
</div>