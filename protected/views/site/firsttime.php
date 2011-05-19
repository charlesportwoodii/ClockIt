<?php
$this->pageTitle=Yii::app()->name . ' - First Time';
$this->breadcrumbs=array(
	'First Login',
);
?>
	<div id="full">
			<h2>Link your Shift Planning Account to ClockIt</h2>
			<center>
				<div class="form">
				
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'link-form',
					'enableAjaxValidation'=>false,
					'errorMessageCssClass'=>'err',
				)); ?>
					<div class="row">
						<?php echo $form->error($model,'spPassword'); ?>
						<?php echo $form->error($model,'newPassword'); ?>
						<?php echo $form->error($model,'newPassword2'); ?>
					</div>
					<div class="row">
					<table>
						<tr>
							<td><? echo $form->label($model, 'Shift Planning Password'); ?>&nbsp;&nbsp;</td>
							<td><?php echo $form->passwordField($model,'spPassword'); ?></td>
						</tr>
						<tr>
							<td><? echo $form->label($model, 'New Password'); ?>&nbsp;&nbsp;</td>
							<td><?php echo $form->passwordField($model,'newPassword'); ?></td>
						</tr>
						<tr>
							<td><? echo $form->label($model, 'New Password (again)'); ?>&nbsp;&nbsp;</td>
							<td><?php echo $form->passwordField($model,'newPassword2'); ?></td>
						</tr>
					</table>
				</div>
				<div class="row">
					<?php echo CHtml::submitButton('Login'); ?>
				</div>
				<?php $this->endWidget(); ?>
				</div><!-- form -->
			</center>
		</div>