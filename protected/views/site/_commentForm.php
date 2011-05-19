	<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'comments-comment-form',
			'enableAjaxValidation'=>false,
		)); ?>
			
			<div class="row">
				<?php echo $form->labelEx($model,'comment'); ?>
				<?php echo $form->textArea($model,'comment', array('rows'=>'5', 'cols'=>'50')); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'type'); ?>
				<?php echo $form->textField($model,'type'); ?>
			</div>

			<div class="row">
				<?php echo $form->error($model,'type'); ?>				
				<?php echo $form->error($model,'comment'); ?>
			</div>

			<div class="buttons">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
			</div>

		<?php $this->endWidget(); ?>

	</div><!-- form -->