<div class="wide form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'post',
	)); ?>
		
		<div class="row" style="margin-left:10%;">
			<?php echo $form->label($model,'dispName'); ?>
			<?php echo $form->dropDownList($model,'uid',CHtml::listData(Users::model()->findAll(), 'uid', 'dispName')); ?>
		<div class="buttons" style="margin-right:10%;">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit', 'style'=>'margin-top:-27px;')); ?>
		</div>
		</div>
		


	<?php $this->endWidget(); ?>

</div><!-- form -->