<div class="wide form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'post',
	)); ?>
		
		<div class="row" style="margin-left:10%;">
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'name'=>'Time[time]',
							'id'=>'time',
							// additional javascript options for the date picker plugin
							'options'=>array(
								'showAnim'=>'clip',
								'dateFormat'=>'yy-mm-dd',
								'changeYear'=>true,
							),
							'htmlOptions'=>array(
								'style'=>'height:20px; width: 150px;'
							),
							'value'=>$timestamp,
						)); ?>
						
			<?php echo $form->dropDownList($model,'uid',CHtml::listData(Users::model()->findAll(), 'uid', 'dispName')); ?>
		
		<div class="buttons" style="margin-right:10%;">
			<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit', 'style'=>'margin-top:-27px;')); ?>
		</div>
		</div>
		


	<?php $this->endWidget(); ?>

</div><!-- form -->