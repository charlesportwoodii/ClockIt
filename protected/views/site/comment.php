<? $this->pageTitle=Yii::app()->name . ' - Comment'; 

$this->breadcrumbs=array(
	'Comment',
);
?>

<div id="fullPage">
	
		<center>
		<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'comments-comment-form',
			'enableAjaxValidation'=>false,
		)); ?>
			<p class="info">Love it? Hate it? Wish it did something else? Leave your feedback here!</p>
			
			<div style="width: 600px;">
				<?php echo $form->error($model,'type'); ?>				
				<?php echo $form->error($model,'comment'); ?>
				<?php if(Yii::app()->user->hasFlash('commentsSuccess')):?>
				<div class="sucs">
					<?php echo Yii::app()->user->getFlash('commentsSuccess'); ?>
				</div>
				<?php endif; ?>
			</div>
			
			<table style="width: 600px;">
				<tr>	
					<td valign="top" style="padding-right: 25px;"><?php echo $form->labelEx($model,'comment'); ?></td>
					<td><?php echo $form->textArea($model,'comment', array('rows'=>'5', 'cols'=>'60')); ?></td>
				</tr>
			</table>
			<table style="width: 600px;">
				<tr>
					<td valign="top" style="padding-right: 25px;"><?php echo $form->labelEx($model,'type'); ?></td>
					<td style="float:left;padding-right: 125px;">
						<?php echo $form->dropDownList($model,'type', array(
							'1'=>'Suggestion',
							'2'=>'Improvement',
							'3'=>'New Feature Request',
							'4'=>'Other',
								)
							); ?>
						</td>
					<td style="float:right;">
						<div class="buttons">
							<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
						</div>
					</td>
				</tr>
			</table>

		<?php $this->endWidget(); ?>

	</div><!-- form -->
	</center>
</div>