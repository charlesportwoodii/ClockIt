<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'uid'); ?>
		<?php echo $form->textField($model,'uid',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spUid'); ?>
		<?php echo $form->textField($model,'spUid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fName'); ?>
		<?php echo $form->dropDownList($model,'fName',CHtml::listData(Users::model()->findAll(), 'fName', 'fName'), array('empty'=>'Any (*)')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lName'); ?>
		<?php echo $form->dropDownList($model,'lName',CHtml::listData(Users::model()->findAll(), 'lName', 'lName'), array('empty'=>'Any (*)')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'phoneNumber'); ?>
		<?php echo $form->textField($model,'phoneNumber',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active'); ?>
		<?php echo $form->dropDownList($model,'active',array('1'=>'Yes', '0'=>'No'), array('empty'=>'Any (*)')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role',CHtml::listData(Roles::model()->findAll(), 'rid', 'name'), array('empty'=>'Any (*)')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'violations'); ?>
		<?php echo $form->textField($model,'violations'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tardies'); ?>
		<?php echo $form->textField($model,'tardies'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'absences'); ?>
		<?php echo $form->textField($model,'absences'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'forgot'); ?>
		<?php echo $form->textField($model,'forgot'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assists'); ?>
		<?php echo $form->textField($model,'assists'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firstLogin'); ?>		
		<?php echo $form->dropDownList($model,'firstLogin',array('1'=>'Yes', '0'=>'No'), array('empty'=>'Any (*)')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->