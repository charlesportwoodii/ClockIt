<div class="form">


<p class="info">Fields with <span class="required">*</span> are required.<br />Password will be unchanged if not specified.</p>
<center>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'users-form',
		'enableAjaxValidation'=>false,
	)); ?>

		<div class="row">	
			<?php if(Yii::app()->user->hasFlash('error')):?>
			<div class="err">
				<?php echo Yii::app()->user->getFlash('error'); ?>
			</div>
		<?php endif; ?>
			<?php echo $form->error($model,'spUid'); ?>
			<?php echo $form->error($model,'email'); ?>
			<?php echo $form->error($model,'password'); ?>
			<?php echo $form->error($model,'fName'); ?>
			<?php echo $form->error($model,'lName'); ?>
			<?php echo $form->error($model,'dispName'); ?>
			<?php echo $form->error($model,'phoneNumber'); ?>
			<?php echo $form->error($model,'address'); ?>
			<?php echo $form->error($model,'city'); ?>
			<?php echo $form->error($model,'state'); ?>
			<?php echo $form->error($model,'zip'); ?>
			<?php echo $form->error($model,'birthday'); ?>
			<?php echo $form->error($model,'active'); ?>
			<?php echo $form->error($model,'role'); ?>
			<?php echo $form->error($model,'violations'); ?>
			<?php echo $form->error($model,'tardies'); ?>
			<?php echo $form->error($model,'absences'); ?>
			<?php echo $form->error($model,'forgot'); ?>
			<?php echo $form->error($model,'assists'); ?>
			<?php echo $form->error($model,'lastAttempt'); ?>
			<?php echo $form->error($model,'firstLogin'); ?>
			<?php echo $form->error($model,'numOfAttempts'); ?>
			<?php echo $form->error($model,'cStatus'); ?>
			<?php echo $form->error($model,'appToken'); ?>
		</div>
		
		<table>
		<tr>
			<td><?php echo $form->labelEx($model,'uid'); ?></td>
			<td><?php echo $form->textField($model,'uid'); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'email'); ?></td>
			<td><?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>200)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'password'); ?></td>
			<td><?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>64)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'fName'); ?></td>
			<td><?php echo $form->textField($model,'fName',array('size'=>60,'maxlength'=>100)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'lName'); ?></td>
			<td><?php echo $form->textField($model,'lName',array('size'=>60,'maxlength'=>100)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'dispName'); ?></td>
			<td><?php echo $form->textField($model,'dispName',array('size'=>60,'maxlength'=>200)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'phoneNumber'); ?></td>
			<td><?php echo $form->textField($model,'phoneNumber',array('size'=>60,'maxlength'=>100)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'address'); ?></td>
			<td><?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'city'); ?></td>
			<td><?php echo $form->textField($model,'city',array('size'=>50,'maxlength'=>50)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'state'); ?></td>
			<td><?php echo $form->textField($model,'state',array('size'=>5,'maxlength'=>5)); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'zip'); ?></td>
			<td><?php echo $form->textField($model,'zip'); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'birthday'); ?></td>
			<td><? $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'name'=>'Users[birthday]',
							'id'=>'Users_birthday',
							'model'=>$model,
							// additional javascript options for the date picker plugin
							'options'=>array(
								'showAnim'=>'clip',
								'dateFormat'=>'yy-mm-dd',
								//'changeYear'=>true,
							),
							'htmlOptions'=>array(
								'style'=>'height:20px;'
							),
							'value'=>substr($model->birthday,0,10),
						));
						?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'active'); ?></td>
			<td><?php echo $form->dropDownList($model,'active',array('1'=>'Activate Account', '0'=>'Deactivate Account'), array('empty'=>'Choose an Option')); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'role'); ?></td>
			<td><?php echo $form->dropDownList($model,'role',CHtml::listData(Roles::model()->findAll(), 'rid', 'name'), array('empty'=>'Choose a Role', 'options'=>array(5=>array('selected'=>'selected')))); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'violations'); ?></td>
			<td><?php echo $form->textField($model,'violations'); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'tardies'); ?></td>
			<td><?php echo $form->textField($model,'tardies'); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'absences'); ?></td>
			<td><?php echo $form->textField($model,'absences'); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'forgot'); ?></td>
			<td><?php echo $form->textField($model,'forgot'); ?></td>
		</tr>

		<tr>
			<td><?php echo $form->labelEx($model,'assists'); ?></td>
			<td><?php echo $form->textField($model,'assists'); ?></td>
		</tr>
		<tr>
			<td><?php echo $form->labelEx($model,'firstLogin'); ?></td>
			<td><?php echo $form->dropDownList($model,'firstLogin',array('1'=>'Yes', '0'=>'No'), array('empty'=>'Any (*)')); ?></td>
		</tr>

		</table>	
			<?php echo $form->hiddenField($model,'lastAttempt'); ?>
			<?php echo $form->hiddenField($model,'numOfAttempts'); ?>
			<?php echo $form->hiddenField($model,'spUid'); ?>
			<?php echo $form->hiddenField($model,'cStatus'); ?>
			<?php echo $form->hiddenField($model,'appToken',array('size'=>60,'maxlength'=>255)); ?>
		<div class="buttons">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
		</div>

	<?php $this->endWidget(); ?>
</center>
</div><!-- form -->