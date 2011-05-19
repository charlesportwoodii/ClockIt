<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forgot-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="info">Fields with <span class="required">*</span> are required.<br /><br />Marking the report as processed will remove it from the queue, and will result in no action being taken on the report.</p>

	<div class="row">
		
		<?php echo $form->error($model,'uid'); ?>		
		<?php echo $form->error($model,'asid'); ?>		
		<?php echo $form->error($model,'submissionTime'); ?>
		<?php echo $form->error($model,'start'); ?>
		<?php echo $form->error($model,'end'); ?>
		<?php echo $form->error($model,'type'); ?>
		<?php echo $form->error($model,'processed'); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uid'); ?>
		<?php echo $form->dropDownList($model,'uid',CHtml::listData(Users::model()->findAll(), 'uid', 'dispName'), array('empty'=>'Any (*)')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'asid'); ?>
		<?php echo $form->textField($model,'asid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start'); ?>
		<?php $this->widget('application.extensions.timepicker.EJuiDateTimePicker',array(
				'model'=>$model,
				'attribute'=>'start',
				'options'=>array(
					'minuteGrid'=>15,
					'stepMinute'=>15,
					'dateFormat'=>'yy-mm-dd',
					'timeFormat' => 'hh:mm:00 tt',
					'showSecond'=>false,
					'changeMonth' => true,
					'changeYear' => false,
					'ampm'=>true,
					),
				));  
			?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end'); ?>
		<?php $this->widget('application.extensions.timepicker.EJuiDateTimePicker',array(
				'model'=>$model,
				'attribute'=>'end',
				'options'=>array(
					'minuteGrid'=>15,
					'stepMinute'=>15,
					'dateFormat'=>'yy-mm-dd',
					'timeFormat' => 'hh:mm:00 tt',
					'changeMonth' => true,
					'changeYear' => false,
					'ampm'=>true,
					),
				));  
			?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList(
			$model,
			'type',
			array(
				'1'=>'System Submission', 
				'2'=>'Late Clock Out',
				'3'=>'Late Clock In',
				'4'=>'Forgot Shift',
				)
			);
			?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'processed'); ?>
		<?php echo $form->dropDownList($model,'processed',array('0'=>'No', '1'=>'Yes')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
	</div>


	<div class="buttons">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
		</div>

<?php $this->endWidget(); ?>

</div><!-- form -->