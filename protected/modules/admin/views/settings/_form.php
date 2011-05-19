<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'server-variables-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="info">Values should be comma separated without spaces. <br /> For example: Puppies,Kittens,Flowers</p>

	<div class="row">
		<?php echo $form->error($model,'name'); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>
		<?php echo $form->hiddenField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->hiddenField($model,'info'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>150)); ?>
		
	</div>

	<div class="buttons">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
		</div>

<?php $this->endWidget(); ?>

</div><!-- form -->