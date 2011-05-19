<?php
$this->pageTitle=Yii::app()->name . ' - Home' ;
$i = 0;
$this->breadcrumbs=array(
	'Home'=>array(''),
);
$this->menu=array(
	array('label'=>'Home', 'url'=>array('/home/index')),
	array('label'=>'Change Password', 'url'=>array('/home/changepassword')),
	array('label'=>'Manage Profile', 'url'=>array('/home/update')),
	array('label'=>'View Forgot Submissions', 'url'=>array('/home/viewforgot')),
	array('label'=>'My Schedule', 'url'=>array('/home/schedule#calendar'))
	);
?>
<div class="fullPage">
	<h3>Announcements</h3>
		<div class="info">
	<? 	if ($messages['data'] != NULL) {		
				foreach ($messages['data'] as $message) {
					if ($i < $numberOfMessages) { // Limit us to three messages
						echo "<b>" . $message['title'] ."</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $message['post'] . "<br />";
						if ($i < $numberOfMessages && $i < sizeof($messages['data']) - 1)
							echo "<br />";
						$i++;
						}
					}
			} 
		else { ?>
			There are no messages at this time.
		<? } ?>
		</div>
	<div class="spacer"></div>
	
	<h3>Upcoming Shifts</h3>
	<div class="upcomming">
			<div id="loadingImg">
				<center>
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" />
					<p>Loading Upcomming Shifts</p>
				</center>
			</div>
	</div>

</div>

<? Yii::app()->clientScript->registerScript(
	'getUpcommingShifts',
	'$.ajax({
		url: "home/GetUpcommingShifts",
		type: "POST",
		success: function(data) {
			$(".upcomming").replaceWith(data);
			},
		error: function() {
			$("#punchBox").bPopup({modalClose: false, escClose: false, vStart: 150});
			setTimeout(function(){$("#punchBox").bPopup().close()},6000);
			},
		complete: function(data) {
			$("#loadingImg").remove();
			}
		});',
	CClientScript::POS_READY); ?>
	
	<div id="punchBox">
		<div id="loading">
			<p>ClockIt was unable to load a list of your upcomming shifts.</p>
		</div>
	</div>