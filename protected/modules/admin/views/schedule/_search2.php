<div class="wide form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'post',
	)); ?>
				
		<div class="row">
			<?php echo $form->label($model,'shift_start'); ?>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'name'=>'Timecards[shift_start]',
							'id'=>'shift_start',
							// additional javascript options for the date picker plugin
							'options'=>array(
								'showAnim'=>'clip',
								'dateFormat'=>'yy-mm-dd',
								'changeYear'=>true,
							),
							'htmlOptions'=>array(
								'style'=>'height:20px; width: 150px; float:left;'
							),
							'value'=>substr($model->shift_start,2),
						)); ?>
			
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'name'=>'Timecards[shift_end]',
							'id'=>'shift_end',
							// additional javascript options for the date picker plugin
							'options'=>array(
								'showAnim'=>'clip',
								'dateFormat'=>'yy-mm-dd',
								'changeYear'=>true,
							),
							'htmlOptions'=>array(
								'style'=>'height:20px; width: 150px; float:right;'
							),
							'value'=>substr($model->shift_end,2),
						)); ?>
			<?php echo $form->label($model,'shift_end', array('style'=>'float:right;')); ?>
			
		</div>
		<div class="row">
			<?php echo $form->label($model,'dispName'); ?>
			<?php echo $form->dropDownList($model,'uid',CHtml::listData(Users::model()->findAll(), 'uid', 'dispName')); ?>
		</div>
		<div class="buttons">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit', 'style'=>'margin-top: -33px;')); ?>
		</div>
		


	<?php $this->endWidget(); ?>

</div><!-- form -->