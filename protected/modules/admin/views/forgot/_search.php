<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
		<?php echo $form->label($model,'uid'); ?>
		<?php echo $form->dropDownList($model,'uid',CHtml::listData(Users::model()->findAll(), 'uid', 'dispName'), array('empty'=>'Any (*)')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'submissionTime'); ?>
		<? $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'name'=>'Forgot[submissionTime]',
						'id'=>'Forgot_submissionTime',
						'model'=>$model,
						// additional javascript options for the date picker plugin
						'options'=>array(
							'showAnim'=>'clip',
							'dateFormat'=>'yy-mm-dd',
						),
						'htmlOptions'=>array(
							'style'=>'height:20px;'
						),
					));
					?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',
			array(
				1=>'System Reported',
				2=>'Late Clock Out',
				3=>'Late Clock In',
				4=>'Entire Shift',
				), array('empty'=>'Any (*)')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->