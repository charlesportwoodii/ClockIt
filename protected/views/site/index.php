<? $this->pageTitle=Yii::app()->name . ' - Automatic Timeclock Software'; ?>
	<div class="wrap">
		<div class="col">
			<h3>Looking for the <span class="red">Timeclock?</span></h3>
			<p class="info">If you're looking for the Team 55 Timeclock, you can find it located <a href="timeclock">here</a>.</p>
			<p>ClockIt has been revamped to allow for several changes. One of these changes is that the timeclock is no longer located on the landing page. Should you need direct access to the timeclock, use the following link:</p>
			<p class="info">
			<a href="<?php echo "https://" . $_SERVER['HTTP_HOST'].Yii::app()->getBaseUrl(); ?>/timeclock" ><?php echo "https://" . $_SERVER['HTTP_HOST'].Yii::app()->getBaseUrl(); ?>/timeclock</a>
			</p>
		</div>
		<div class="col">
			<h3>My <span class="red">Timesheet</span></h3>
			<p class="info">Use ClockIt to verify your timesheet before submitting it.</p>
			<p>Before submitting your timesheet, you should use ClockIt to verify that the times you are submitting are accurate. Times submitted to banner that are not in ClockIt will be removed, and times not submitted to banner but in ClockIt will not be automatically added. It is your responsability to ensure your timesheet is accurate.</p>
			<p>Reviewing your timesheet is simple, just click on the <a href="<? echo Yii::app()->getBaseUrl(); ?>/home">home</a> link to view your times.</p>
		</div>
		<div class="col last">
			<h3>Keey Up To <span class="red">Data</span></h3>
			<p class="info">The Team 55 Twitter feed is the number one way to stay informed about unexpected outages and issues. Before beginning your shift you should check the twitter feed to see if any new issues have arisen.</p>
			<div id="data">
			</div>
	<? $this->renderPartial('_ajaxTwitter', NULL, false, true); ?>
	<br /><br />
		</div>
	</div>