<? 
$this->pageTitle=Yii::app()->name . ' - Forgot To ClockIt?' ;
$this->breadcrumbs=array(
	'Home'=>array('../home'),
	'Forgot to ClockIt',
);
$this->menu=array(
	array('label'=>'Home', 'url'=>'../home'),
	array('label'=>'Change Password', 'url'=>'changepassword'),
	array('label'=>'Manage Profile', 'url'=>'update'),
	array('label'=>'Forgot to ClockIt?', 'url'=>'forgot'),
	array('label'=>'View Forgot Submissions', 'url'=>'viewforgot'),
	array('label'=>'My Schedule', 'url'=>'schedule')
	);
?>
<style>
	.fullPage input {
		float:left;
		}
</style>

<div class="fullPage">
	<h3>Submit a Forgotten Shift</h3>
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'users-update-form',
			'enableAjaxValidation'=>false,
		)); ?>
		<div class="row">
			<? echo $form->error($model,'start'); ?>
			<? echo $form->error($model,'end'); ?>
			<? echo $form->error($model,'type'); ?>
			<?php if(Yii::app()->user->hasFlash('forgotSubmitted')):?>
					<div class="sucs">
						<?php echo Yii::app()->user->getFlash('forgotSubmitted'); ?>
					</div>
				<?php endif; ?>
		</div>
		
		<div class="row">
				<?php echo $form->label($model,'start'); ?>
				<?php $this->widget('application.extensions.timepicker.timepicker', array(
						'model'=>$model,
						'name'=>'start',
						'id'=>'Forgot_start',
					));
					?>
			</div>
			<div class="row">
				<?php echo $form->label($model,'end'); ?>
				<?php $this->widget('application.extensions.timepicker.timepicker', array(
						'model'=>$model,
						'name'=>'end',
						'id'=>'Forgot_end'
					));
					?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($model,'type'); ?>
				<br /><br />
				<?php echo $form->radioButtonList($model,'type',
					array(
						"1"=>"I clocked into my shift <i>after</i> it had started.",
						"2"=>"I clocked out of my shift <i>after</i> it had ended.",
						"3"=>"I did not clock into my shift.",
						"4"=>"I forgot to clock out of my shift.",
						)
					); ?>
			</div>
			
			<div class="buttons">
				<?php echo CHtml::htmlButton('Submit', array('class'=>'positive', 'type'=>'submit')); ?>
			</div>
			
		<?php $this->endWidget(); ?>
	</div>
</div>