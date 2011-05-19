<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
		<div id="full">
			<h2>Login</h2>
			<center>
				<div class="form">
				
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'focus'=>array($model,'username'),
					'enableAjaxValidation'=>true,
					'errorMessageCssClass'=>'err',
				)); ?>
					<div class="row">
						<?php if( isset($_GET['s'] ) ):?>
							<div class="sucs">
								Your account information has been syncronized. You may now log into ClockIt.
							</div>
						<?php endif; ?>
						
						<?php echo $form->error($model,'username'); ?>
						<?php echo $form->error($model,'password'); ?>
					</div>
					
					<div class="row">
						<?php echo $form->textField($model,'username'); ?>
					</div>

					<div class="row">
						<?php echo $form->passwordField($model,'password'); ?>
					</div>

					<div class="row buttons">
						<?php echo CHtml::submitButton('Login'); ?>
					</div>

				<?php $this->endWidget(); ?>
				</div><!-- form -->
			</center>
		</div>