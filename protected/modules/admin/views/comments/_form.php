<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="info">Fields with <span class="required">*</span> are required.</p>

	<div class="row">	
		<?php echo $form->error($model,'uid'); ?>
		<?php echo $form->error($model,'type'); ?>
		<?php echo $form->error($model,'timestamp'); ?>
		<?php echo $form->error($model,'comment'); ?>
		<?php echo $form->error($model,'processed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uid'); ?>
		<?php echo $form->textField($model,'uid',array('size'=>20,'maxlength'=>20)); ?>
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'processed'); ?>
		<?php echo $form->textField($model,'processed'); ?>
	</div>

	<div class="buttons">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
		</div>

<?php $this->endWidget(); ?>

</div><!-- form -->