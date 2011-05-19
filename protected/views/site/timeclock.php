<?php
$this->pageTitle=Yii::app()->name . ' - Timeclock';
$this->breadcrumbs=array(
	'Timeclock',
);

$this->menu=array(
	);
?>
	<? Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/easySlider1.7.js'); ?>
	<? Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bPopup.js'); ?>
	<? Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/screen2.css'); ?>
	
	<div class="fullPage">
		<center>
			<div class="form">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'clock-form',
					'focus'=>array($model,'uid'),
					'enableAjaxValidation'=>true,
					'errorMessageCssClass'=>'err',
					'htmlOptions'=>array('name'=>'clock-form'),
				)); ?>
			<div class="row">
				<?php echo $form->textField($model,'uid', array('class'=>'clockForm', 'disabled'=>in_array(Yii::app()->request->userHostAddress, $model->attributes['allowedIps'])?false:true)) ?>
			</div>
			<div class="row">
				<?php echo $form->error($model,'uid'); ?>
			</div>
            <?php echo  CHtml::ajaxSubmitButton(
				'Submit',
				CHtml::normalizeUrl(array('site/punch','uid'=>$model->uid)),
                array(
					'type'=>'POST',
					'clearForm'=>true,	
					'timeout'=>'5000', // 5 Second timeout. If we still haven't received a response yet, we need to bail and let someone know
					'beforeSend' => 'function(request) {
					
					// Load up the popup box
						$("#punchBox").bPopup({modalClose: false, escClose: false, vStart: 150});
						
					// Disable the form to prevent "Double Punch"
						$("form#clock-form :input").attr("disabled", "disabled").blur();
						
                     }',
					'success'=>'function(data){
						// Load up the window with the appropriate response
						$("#loading").replaceWith(data);
                        }',
					'error'=>'function(data){
						// Used on ajax error, not data submission errors
						$("#loading").replaceWith("<strong>An unexpected error has occured</strong><br/>ClockIt was unable to communicate to the server. Please try your request again. If you continue to receive this error, check to make sure your still have an active internet connection");
                        }',
					'complete'=>'function(data){
					
					// Close the popup box after 6 seconds
						setTimeout(function(){$("#punchBox").bPopup().close()},6000);
					// Revert the popup box to the original data set
						setTimeout(function(){$("#loading").replaceWith(loadingForm)},6250);
						
					// Re-enable our form
						setTimeout(function(){$("form#clock-form :input").removeAttr("disabled")},6050);
						setTimeout(function(){$("form#clock-form :input").val("").focus()},6050);
					
					// Reload Who is In
						whoIsIn();
                        }',
					),
				array(
					'style'=>'visibility: hidden;',
					)
               ); ?>
			<?php $this->endWidget(); ?>
			</div>
		</center>
	</div>
	<!-- Sidebar -->
	<div class="last">
		<div class="sidebar">
			<div id="slider"> 
			<ul>				
				<li>
					<center><h3>Who is In?</h3></center>
					<div class="data1">
						<center>
							<br />
							<br />
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" />
							<br />
							<br />
							<p>Please wait while this view is generated.</p>
						</center>
					</div>
				</li>
				<li>
					<center><h3>Twitter Feed</h3></center>
					<div class="data2">
						<center>
							<br />
							<br />
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" />
							<br />
							<br />
							<p>Please wait while this view is generated.</p>
						</center>
					</div>
				</li>			
				<li>
					<center><h3>Pingdom Status</h3></center>
					<div class="data3">
						<center>
							<br />
							<br />
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" />
							<br />
							<br />
							<p>Please wait while this view is generated.</p>
						</center>
					</div>
				</li>	
				<li>
					<center><h3>Messages</h3></center>
					<div class="data4">
						<center>
							<br />
							<br />
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" />
							<br />
							<br />
							<p>Please wait while this view is generated.</p>
						</center>
					</div>
				</li>
			</ul> 
		</div> 
		</div>
	</div>		
	
	<div id="punchBox">
		<div id="loading">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif"/>
			<p>Please wait while ClockIt processes your request</p>
		</div>
	</div>

<script type="text/javascript">
	// Default data for our loading form. Made global so that it is accessible by all data functions
	var loadingForm = '<div id="loading"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" /><p>Please wait while ClockIt processes your request</p></div>';
	var loadingImg = '<div id="loadingImg"><center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" /><p>Updating View...</p></center></div>';
	var loadingImg4 = '<div id="loadingImg4"><center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" /><p>Updating View...</p></center></div>';
	var loadingImg3 = '<div id="loadingImg3"><center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" /><p>Updating View...</p></center></div>';
	var loadingImg2 = '<div id="loadingImg2"><center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" /><p>Updating View...</p></center></div>';
	
	function whoIsIn() {
		// Append loading dialog
		$.ajax({
				url: 'site/whoIsIn',
				type: 'POST',
				beforeSend: function() {
					$(".data1").append(loadingImg);
					},
				success: function(data) {
					$(".data1").replaceWith(data);
					},
				error: function() {
					$("#loadingImg").remove();
					},
				complete: function() {
					$("#loadingImg").remove();
					}
				});
		}
	// Updates the "Who Is In", "Twitter", and "Pingdom" divs every 30 minutes with new information. If an error occurs, do nothing
	function updateData() {	
		// Update Who is In
		whoIsIn();	
		
		// Update Twitter Feed
			$.ajax({
				url: 'site/twitter',
				type: 'POST',
				beforeSend: function() {
					$(".data2").append(loadingImg2);
					},
				success: function(data) {
					$(".data2").replaceWith(data);
					},
				error: function() {
					$("#loadingImg2").remove();
					},
				complete: function() {
					$("#loadingImg2").remove();
					}
				});
				
		// Update Pingdom Display
			$.ajax({
				url: 'site/pingdom',
				type: 'POST',
				beforeSend: function() {
					$(".data3").append(loadingImg3);
					},
				success: function(data) {
					$(".data3").replaceWith(data);
					},
				error: function() {
					$("#loadingImg3").remove();
					},
				complete: function() {
					$("#loadingImg3").remove();
					}
				});
				
		// Update ShiftPlanning Messages Display
			$.ajax({
				url: 'site/spMessages',
				type: 'POST',
				beforeSend: function() {
					$(".data4").append(loadingImg4);
					},
				success: function(data) {
					$(".data4").replaceWith(data);
					},
				error: function() {
					$("#loadingImg4").remove();
					},
				complete: function() {
					$("#loadingImg4").remove();
					}
				});
				
		// Call this again just incase, cleanup
			$("#loadingImg4").remove();	
			$("#loadingImg3").remove();	
			$("#loadingImg2").remove();	
			$("#loadingImg").remove();	
		// Call self again after 30 minutes
			setTimeout(function(){updateData()},1800000);
			}			
	
	// Begin Update
	updateData();
	
	$(document).ready(function(){
		// Clear the input form on page load
		$('form#clock-form :input').val("");
		
		// Load our slider function
		$("#slider").easySlider({ 
			controlsShow: false,
			pause: 15000,
			speed: 600,
			auto: true,
			continuous: true,
			numeric: true,
		});
	});
</script>