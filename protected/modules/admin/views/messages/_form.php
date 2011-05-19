<div class="form">


<p class="info">Fields with <span class="required">*</span> are required.</p>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'messages-form',
		'enableAjaxValidation'=>false,
	)); ?>

		<div class="row">		
			<?php echo $form->error($model,'title'); ?>
			<?php echo $form->error($model,'post'); ?>
			<?php echo $form->error($model,'sticky'); ?>
		</div>
		<center>
		<table>
			<tr>
				<td><?php echo $form->labelEx($model,'title'); ?></td>
				<td><?php echo $form->textField($model,'title'); ?></td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model,'post'); ?></td>
				<td><?php echo $form->textArea($model,'post', array('rows'=>10, 'cols'=>30)); ?></td>
			</tr>
	<? /*
			<tr>
				<td><?php echo $form->labelEx($model,'sticky'); ?></td>
				<td><?php echo $form->checkBox($model,'sticky'); ?></td>
			</tr>
		*/ 
		?>
			<? echo $form->hiddenField($model, 'id'); ?>
		</table>	
		<div class="buttons">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
		</div>
		
</center>
	<?php $this->endWidget(); ?>
</div><!-- form -->