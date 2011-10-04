<?php

class DefaultController extends Controller
{
	public $layout='//layouts/column2';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','banner', 'export', 'changepassword','update','viewforgot','viewforgotcomments','schedule','getUpcommingShifts','scheduledShifts', 'forgotHelper', 'test'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		// Initialize the ShiftPlanning API
		$connection = new spConnect();
		$sp = $connection->connectToShiftPlanning();
		// Set the Number of Messages to show and to pass to our view
			$numberOfMessages = 2;
		
		/********************************************************************
		*	The content apccached here is /globally/ accessable. We want this 
		*	View to be available to all users
		*********************************************************************/
		
		$messages = $sp->getWallMessages();
		
		// Render the view
		$this->render('index', 
			array( 
			'messages'=>$messages,
			'numberOfMessages'=>$numberOfMessages,
			)
		);
		
	}
	
	/**
	  *	Retrieves a listing of upcomming shifts to put up on the front page of our site.
	  *
	  **/
	public function actionGetUpcommingShifts()
	{
		// Connect to ShiftPlanning
		$connection = new spConnect();
		$sp = $connection->connectToShiftPlanning();
		// Render a Partial View
		$this->renderPartial('_upcommingShifts', array('sp'=>$sp), false, true);
		}
	
	/**
	  *	Provides functionality for the user to change his password
	  *
	  **/
	public function actionChangePassword()
	{
		$model=new HomeChangePassword;
		if(isset($_POST['HomeChangePassword']))
		{
			$_POST['HomeChangePassword']['username'] = Yii::app()->user->getState('email');
			$model->attributes=$_POST['HomeChangePassword'];
			// Validate input
			if($model->validate()) {
				// Syncronize if Valid
				$model->sync();
				Yii::app()->user->setFlash('changePassSuccess',"Your password has sucessfully been changed.");
				unset($_POST['HomeChangePassword']);
				$_POST['HomeChangePassword'] = array('username'=>'', 'oldPassword'=>'', 'newPassword'=>'', 'newPassword2'=>'');
				$model->attributes = $_POST['HomeChangePassword'];
				}
		}
		$this->render('changepassword', array('model'=>$model));
	}
	
	public function actionUpdate() 
	{
		$model = new Users;
		$data = Users::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$model->attributes = $data['attributes'];
		
		if(isset($_POST['Users']))
		{
			$model->dispName = $_POST['Users']['dispName'];
			$model->address = $_POST['Users']['address'];
			$model->city = $_POST['Users']['city'];
			$model->state = $_POST['Users']['state'];
			$model->zip = $_POST['Users']['zip'];
			$model->phoneNumber = $_POST['Users']['phoneNumber'];
			$model->birthday = $_POST['Users']['birthday'];
			
			// Validate
			if ($model->validate()) {
				// Update model on Validation
				$model->updateByPk($model->attributes['uid'], $model->attributes);
				
				// Update message
				Yii::app()->user->setFlash('updateProfile',"Your profile information has been updated.");
				
				// Parsing for ShiftPlanning
				$birthday = explode("-",$model->birthday);
				// Push new data to ShiftPlanning
				$connection = new spConnect();
		$sp = $connection->connectToShiftPlanning();
				$update = $sp->updateEmployee(Yii::app()->user->getState('spId'), array('name'=>$model->dispName, 'address'=>$model->address, 'city'=>$model->city, 'state'=>$model->state, 'zip'=>$model->zip, 'birth_day'=>$birthday[2], 'birth_month'=>$birthday[1]));
				
				}
			}
		$this->render('update', array('model'=>$model));
	}

	
	
	public function actionViewForgot() 
	{
		$dataProvider=new CActiveDataProvider(
			'Forgot',
			array(
				'criteria'=>array(
					'condition'=>'uid='. Yii::app()->user->id,
					'order'=>'submissionTime DESC',
				),
			'pagination'=>array(
				'pageSize'=>20,
				),
			)
		);
        $this->render('viewforgot',array('dataProvider'=>$dataProvider));
	}
	
	public function actionViewForgotComments() 
	{
		// New data provider
		if (!isset($_POST['id']))
			$_POST['id'] = -1;
		$dataProvider=new CActiveDataProvider(
			'Forgot',
			array(
				'criteria'=>array(
					'condition'=>'uid='. Yii::app()->user->id . ' AND id=' .$_POST['id'],
				),
			)
		);
		
		// If we didn't find a record that matched we need to redirect to a 403 page
		if ($dataProvider->getItemCount() == 0)
			throw new CHttpException(403,'You do not have permission to view this comment');
			
		// Render the view
		$this->renderPartial('viewforgotcomments', array('dataProvider'=>$dataProvider));
	}
	
	public function actionSchedule() 
	{
		// Set a 1 Column page layout
		$this->layout='//layouts/column1';
		yii::app()->clientscript->registercssfile(yii::app()->baseurl.'/css/jquery-ui.css'); 
		yii::app()->clientscript->registercssfile(yii::app()->baseurl.'/css/jquery.weekcalendar.css');
		yii::app()->clientscript->registercssfile(yii::app()->baseurl.'/css/calendar.css');		
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/screen2.css');
		
		// Load the necessary JS Files
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.min.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.min.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.weekcalendar.js');		
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bPopup.js');
		
		$model = new Forgot;
		$model->type=3;			// Set the default type to 3 "clocked into my shift late"
		$this->render('schedule', array('model'=>$model));
	}
	
	/**
	 *	Shows a banner view for easy submission
	 */
	public function actionBanner()
	{
		$this->layout = false;
		$connection=Yii::app()->db;
		
		$sql = "SELECT uid, shift_start, shift_end FROM timecards WHERE uid = :uid AND shift_start >= :timestamp AND shift_start < shift_end AND shift_end <> '0000-00-00 00:00:00' ORDER BY shift_start";
		
		$timestamp = date("Y-m-d 00:00:00", strtotime("20 days ago"));
		
		if (isset($_GET['ts']))
		{
			$timestamp = $_GET['ts'] . " 00:00:00";
		}
		
		$command=$connection->createCommand($sql);
		$command->bindParam(":uid",Yii::app()->user->id,PDO::PARAM_STR);
		$command->bindParam(":timestamp",$timestamp,PDO::PARAM_STR);
		$dataReader = $command->queryAll();
		$model = new Users();
		$spUid = $model->getSPuid(Yii::app()->user->id);
		$connection = new spConnect();
		$sp = $connection->connectToShiftPlanning();
		
		$this->render('banner', array('dataReader'=>$dataReader, 'spUid' => $spUid, 'sp' => $sp));
	}
	
	/**
	 *	Exports shift data out as a CSV
	 */
	public function actionExport()
	{
		
		Yii::import('ext.parsecsv');	
		$csv = new parsecsv();
		$connection=Yii::app()->db;
		
		$sql = "SELECT uid, shift_start, shift_end FROM timecards WHERE uid = :uid AND shift_start >= :timestamp";
		$name='report';
		$headers=array(array('uid'=>'Banner Id', 'shift_start'=>'Start_Time', 'shift_end'=>'End_Time'));
		
		$timestamp = date("Y-m-d 00:00:00", strtotime("20 days ago"));
		
		if (isset($_GET['ts']))
		{
			$timestamp = $_GET['ts'] . " 00:00:00";
		}
		
		$command=$connection->createCommand($sql);
		$command->bindParam(":uid",Yii::app()->user->id,PDO::PARAM_STR);
		$command->bindParam(":timestamp",$timestamp,PDO::PARAM_STR);
		$dataReader = $command->queryAll();
		$csv->output (true, $name . '.csv', array_merge($headers,$dataReader));
		
	}

	public function actionScheduledShifts() {
                // Connect to ShiftPlanning
                $connection = new spConnect();
                $sp = $connection->connectToShiftPlanning();

                $shift_start = date("Y-m-d 00:00:00", $_GET['start']);
                $shift_end = date("Y-m-d 00:00:00", $_GET['end']);

                $sql = 'uid='. Yii::app()->user->id . ' AND shift_end != "0000-00-00 00:00:00" AND shift_start != shift_end AND shift_start > "' . $shift_start . '" AND shift_end < "' . $shift_end . '"';
                // Load a data provider with shift information
                $dataProvider=new CActiveDataProvider(
                        'Timecards',
                        array(
                                'criteria'=>array(
                                        'condition'=>$sql
                                ),
                        )
                );

                $this->renderPartial('_scheduledShifts', array('sp'=>$sp, 'dataProvider'=>$dataProvider), false, true);
                }
	
	public function actionforgotHelper() {
		if (isset($_POST['Forgot'])) {			
			$model = new Forgot;
			
			// Reformat the ajax start time to something a little php friendlier
			$_POST['Forgot']['start'] = date(
				"Y-m-d H:i:s",
				strtotime(
					str_replace(
						"GMT" . date("O",time()) . " (Central Daylight Time)", 
						"", 
						$_POST['Forgot']['start']
						)
					)
				);
			
			// Reformat the ajax start time to something a little php friendlier			
			$_POST['Forgot']['end'] = date(
				"Y-m-d H:i:s",
				strtotime(
					str_replace(
						"GMT" . date("O",time()) . " (Central Daylight Time)", 
						"", 
						$_POST['Forgot']['end']
						)
					)
				);
	
			// Make sure that we are getting the correct attributes
			$_POST['Forgot']['uid'] = Yii::app()->user->id;
			$_POST['Forgot']['submissionTime'] = date("Y-m-d H:i:s", time());
			$_POST['Forgot']['processed'] = 0;
			$_POST['Forgot']['comment'] = "User Comment: " . $_POST['Forgot']['comment'];
			
			$model->attributes = $_POST['Forgot'];
			
			// Validate our model via basic validation rules
			if ($model->validate()) {
				// Save our model now. =)
				$model->save();
				
				// output success messages
				echo "Your submission has been sucessfully saved. This window will automatically close in a few seconds";
				}
			else	// Debugging
				print_r($model->getErrors());
		}
	}
	
	public function actionTest() {

	}
}
	
	
