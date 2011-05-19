<?php
$this->pageTitle=Yii::app()->name . ' - Change Password' ;
$this->breadcrumbs=array(
	'Home'=>array('../home'),
	'Change Password'
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
	<h3>Change Password</h3>
		<div class="form">
		<center>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'ChangePassword',
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="row">
			<?php if(Yii::app()->user->hasFlash('changePassSuccess')):?>
				<div class="sucs">
					<?php echo Yii::app()->user->getFlash('changePassSuccess'); ?>
				</div>
				<?php endif; ?>
			</div>	
			<div class="row">
				<?php echo $form->error($model,'oldPassword'); ?>				
				<?php echo $form->error($model,'newPassword'); ?>
				<?php echo $form->error($model,'newPassword2'); ?>
			</div>
			
			<table>
				<tr>
					<td><?php echo $form->labelEx($model,'oldPassword'); ?></td>
					<td><?php echo $form->passwordField($model,'oldPassword'); ?></td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model,'newPassword'); ?></td>
					<td><?php echo $form->passwordField($model,'newPassword'); ?></td>
				</tr>
				<tr>
					<td><?php echo CHtml::label('New Password (again):',false, array('style'=>'width: 100%;')); ?></td>
					<td><?php echo $form->passwordField($model,'newPassword2'); ?></td>
				</tr>
			</table>
			
			<br />
			
			<div class="buttons">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
			</div>

		<?php $this->endWidget(); ?>
		</center>
	</div><!-- form -->
</div>