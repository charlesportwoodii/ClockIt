<?php

class SiteController extends Controller
{
	public $layout='//layouts/main';

	
	private function roundTime($timestamp, $precision = 15) {
		$timestamp = strtotime($timestamp);
		$precision = 60 * $precision;
		return date('Y-m-d H:i:s', round($timestamp / $precision) * $precision);
		}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if($this->beginCache('frontPageTwitterFeed', array('duration'=>1800))) {		
			$this->render('index');
		$this->endCache(); } 
	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout='//layouts/column1';
		ob_start('ob_gzhandler');
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$this->layout='//layouts/column1';
		$model=new LoginForm;

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) { 
				if (Yii::app()->user->getState('firstLogin') == 1)
					$this->redirect('firsttime');
				$this->redirect(Yii::app()->user->returnUrl);
				}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	/**
	  * First Time Initialization Script
	  * Syncronizes ClockIt to ShiftPlanning for dual authentication
	  **/
	public function actionFirsttime() {
		$this->layout='//layouts/column1';
		if (Yii::app()->user->getState('firstLogin') == 0)
			$this->redirect(array('/home'));
		$model=new LinkForm;

		// collect user input data
		if(isset($_POST['LinkForm']))
		{
			$model->attributes=$_POST['LinkForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate()) {
				// Syncronize ClockIt to ShiftPlanning
				$model->sync();
				Yii::app()->user->logout();
				$this->redirect(array('/login?s=1'));
				}
		}
		// Display the form
		$this->render('firsttime', array('model'=>$model));
		}
	
	/*
	 * Renders the Timeclock Display
	 */	 
	public function actionTimeclock() {
	// Automatically log out of they are logged in
	$this->layout='//layouts/column1';
		if (!Yii::app()->user->isGuest) {
			// Log the user out
			Yii::app()->user->logout();
			
			// Instantiate ShiftPlanning
			Yii::import("application.extensions.shiftplanning.YShiftPlanning");
					$sp = new YShiftPlanning(
						array('key' => Yii::app()->params['SPAPIKey'] // enter your developer key
							)
						);
			// Log Out of Shift Planning
			$sp->doLogout();
		}
		
		// Load the Timeclock Model
		$model = new Timeclock;
		
		// Retrieve the current allowed IP Addresses
		$sp = ServerVariables::model()->findByAttributes(array('name'=>'allowedIps'));
		
		// Save it to our model
		$model->updateIps($sp->value);
		
		// Display the form
		$this->render('timeclock', array('model'=>$model));
		}
	
	/*
	 *	Punches the user into the system. Not accessible via /site/punch as it is partially rendered via an Ajax Call.
	 *	!! Do not try to access this function outside of an Ajax Call. It will Fail !!
	 */
	public function actionPunch()
    {
		$model = new Timeclock;
		
		// Retrieve our allowed IP Addresses and update our Model
		$sp = ServerVariables::model()->findByAttributes(array('name'=>'allowedIps'));
		$model->updateIps($sp->value);
				
		// collect user input data
		if(isset($_POST['Timeclock']))
		{
			$model->attributes=$_POST['Timeclock'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate()) {
			
				// Create a timestmap rounded to the nearest 15 minutes
				$timestamp = $this->roundTime(date('Y-m-d H:i:s', time()));
				
				$flag = false;
				
				$connection=Yii::app()->db;
				if ($model->cStatus == 0) {			// If the retrive valued indicates the user was not on the clock
													// We should clock them in
													
					// If they are clocking in, check the previous shift to see if the previous shift_end and current time() are equivalent (within a minute)
					// If it is we need to file a forgot to ClockIt Report and flag it as requiring correction
					
					$sql="SELECT pid, shift_start, shift_end FROM timecards WHERE uid = :uid ORDER BY pid DESC LIMIT 0,1";
					$command = $connection->createCommand($sql);
					$command->bindParam(":uid", $model->uid, PDO::PARAM_STR);
					$data = $command->query();
					
					// Retrieve the last shift end time;
					foreach ($data as $row) {
						$asid = $row['pid'];
						$shift_start = $row['shift_start'];
						$shift_end = $row['shift_end'];
						}
					
					
					// Compare the previous shift end to the current time, and flag an error 
					if($timestamp == $shift_end) {
						$flag = true;
						}
					
					$sql="INSERT INTO timecards SET uid = :uid, shift_start = :timestamp";
					$command = $connection->createCommand($sql);
					$command->bindParam(":uid", $model->uid, PDO::PARAM_STR);
					$command->bindParam(":timestamp", $timestamp, PDO::PARAM_STR);
					$command->execute();
					
				// Update the users table
					$sql="UPDATE users SET cStatus = 1 WHERE uid = :uid";
					$command = $connection->createCommand($sql);
					$command->bindParam(":uid", $model->uid, PDO::PARAM_STR);
					$command->execute();
					}
				else {
				// Retrieve the last Punch Id from the system
					$sql="SELECT pid FROM timecards WHERE uid = :uid ORDER BY pid DESC LIMIT 0,1";
					$command = $connection->createCommand($sql);
					$command->bindParam(":uid", $model->uid, PDO::PARAM_STR);
					
				// Retrieve it for usage
					$data = $command->query();
						foreach ($data as $row)
							$pid = $row['pid'];
					
				// Punch out
					$sql="UPDATE timecards SET shift_end = :timestamp WHERE pid = :pid";
					$command = $connection->createCommand($sql);
					$command->bindParam(":timestamp", $timestamp, PDO::PARAM_STR);
					$command->bindParam(":pid", $pid, PDO::PARAM_STR);
					$command->execute();
					
				// Update the users table
					$sql="UPDATE users SET cStatus = 0 WHERE uid = :uid";
					$command = $connection->createCommand($sql);
					$command->bindParam(":uid", $model->uid, PDO::PARAM_STR);
					$command->execute();
					}
				
				// Display output information
				$text = "on";
				if ($model->cStatus == 1)
					$text = "off";
					
				// On/off the clock Message
				if ($flag) {
					// Flag a Forgot to ClockIt report associated with this shift id
								
					$forgot = new Forgot;
					
					// Populate the model with the appropriate data
					$forgot->attributes = 
						array(
							'uid'=>$model->uid, 
							'asid'=>$asid, 
							'submissionTime'=>date('Y-m-d H:i:s', time()), 
							'start'=>$shift_start, 
							'end'=>$shift_end, 
							'type'=>2, 									// Type 2 indicated "clock out late" 
							'processed'=>0, 
							'comment'=>"Automatic submission from Clockit. User forgot to clock out of a previous shift."
							);
							
					$forgot->save();
					
					
					// Display a nice error message to let them know we took care of this for them
					echo '<div id="loading" class="ntc" style="position:relative;top:-25px;">ClockIt has detected that you forgot to clock out of your previous shift, and has automatically filed a Forgot to ClockIt submission for this shift. No futher action is required on your part.<br /><br />You are now ' . $text . ' the clock.</div>';
					}
				else
					echo '<div id="loading" class="' . ($text == 'on' ? 'sucs' : 'info2'). '">Thank you for clocking your time. You are now ' . $text . ' the clock!</div>';
				}
			else {
			
				// Perform CModel Validation on the fly to produce output that contains a valid error message, and do some cleanup
				$valData = CActiveForm::validate($model);
				$valData = str_replace('{"Timeclock_uid":["',"",$valData);
				$valData = str_replace('"]}',"",$valData);
				$valData = str_replace('Uid',"Barcode",$valData);
				
				// Return our error/success message
				echo '<div id="loading" class="err">' . $valData . '</div>';
				}
			}
		}
	
	public function actionComment()
	{
		if (Yii::app()->user->isGuest) {
			Yii::app()->user->setReturnUrl('site/comment');
			$this->redirect(array('/login'));
			}
			
		$this->layout='//layouts/column1';
		$model=new Comments;

		if(isset($_POST['Comments']))
		{
			$_POST['Comments']['timestamp'] = date("Y-m-d H:i:s",time());
			$_POST['Comments']['uid'] = Yii::app()->user->id;
			$_POST['Comments']['processed'] = 0;
			$model->attributes=$_POST['Comments'];
			if($model->validate())
			{
				$model->save();
				Yii::app()->user->setFlash('commentsSuccess',"Your comment has been saved! Thank you for your feedback");
				unset($_POST['Comments']);
				$_POST['Comments'] = NULL;
			}
		}
		$this->render('comment',array('model'=>$model));
	}
		
	public function actionWhoIsIn() {
		// Echo a list of everyone who is on the clock
		$this->renderPartial('whoIsIn', NULL, false, true);
		}

    public function actionWhoIsInJson()
    {
        $response = Users::model()->findAll('cStatus = 1');
        
        $result = array();
        foreach($response as $v)
        {
            $result[] = array('id'=>$v['uid'], 'value'=>$v['dispName']);
        }

        echo json_encode($result);
    }
    
	public function actionTwitter() {
		// Echo the current twitter feed
		$this->renderPartial('twitter', NULL, false, true);
		}
		
	public function actionPingdom() {
		// Echo Pingdom Statistics
		$this->renderPartial('pingdom', NULL, false, true);
		}
		
	public function actionSpMessages() {
		// Echo the latest ShiftPlanning Messages
		$this->renderPartial('spMessages', NULL, false, true);
		}
		
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$connection = new spConnect();
		$sp = $connection->connectToShiftPlanning();
		$sp->doLogout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
