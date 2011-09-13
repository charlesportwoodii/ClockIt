<?php

class ScheduleController extends Controller
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
				'actions'=>array('index','scheduledShifts', 'viewschedule', 'banner', 'export', 'forgotHelper'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->role<=2',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 *	Tabular display of shifts by user
	 */
	public function actionIndex()
	{
		$this->redirect('schedule/viewschedule');
	}
	
	/**
	 *	Shows a banner view for easy submission
	 */
	public function actionBanner()
	{
		$this->layout = false;
		$connection=Yii::app()->db;
		
		$sql = "SELECT uid, shift_start, shift_end FROM timecards WHERE uid = :uid AND shift_start >= :timestamp";
		
		$timestamp = date("Y-m-d 00:00:00", strtotime("20 days ago"));
		
		if (isset($_GET['ts']))
		{
			$timestamp = $_GET['ts'] . " 00:00:00";
		}
		
		$command=$connection->createCommand($sql);
		$command->bindParam(":uid",$_GET['uid'],PDO::PARAM_STR);
		$command->bindParam(":timestamp",$timestamp,PDO::PARAM_STR);
		$dataReader = $command->queryAll();
		
		$this->render('banner', array('dataReader'=>$dataReader));
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
		$command->bindParam(":uid",$_GET['uid'],PDO::PARAM_STR);
		$command->bindParam(":timestamp",$timestamp,PDO::PARAM_STR);
		$dataReader = $command->queryAll();
		$csv->output (true, $name . '.csv', array_merge($headers,$dataReader));
		
	}
	
	public function actionViewSchedule()
	{
		// Set a 1 Column page layout
		$this->layout='//layouts/column2';
		
		// Load the necessary CSS Files
		yii::app()->clientscript->registercssfile(yii::app()->baseurl.'/css/jquery-ui.css'); 
		yii::app()->clientscript->registercssfile(yii::app()->baseurl.'/css/jquery.weekcalendar.css');
		yii::app()->clientscript->registercssfile(yii::app()->baseurl.'/css/calendar.css');		
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/screen2.css');
		
		// Load the necessary JS Files
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.min.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.min.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.weekcalendar.js');		
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bPopup.js');
		
		// We don't want to use Yii's version of jQuery, as it is incompadible with the calendar
		Yii::app()->clientScript->scriptMap=array('jquery.js'=>false);
		
		$model = new Users('search');
		
		$model2 = new Forgot;
		$model2->type = 2;			// Set a default type to prevent invalid submissions
		
		$model->unsetAttributes();  // clear any default values
		
		// Decide which user we are using
		if(isset($_POST['Users'])) 
		{
			$model = $this->loadModel($_POST['Users']['uid']);
		}
		else
		{
			$model = $this->loadModel(Yii::app()->user->id);
		}
		
		$this->render('viewschedule', array('model'=>$model, 'forgot'=>$model2));
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
	
	public function actionScheduledShifts() {
		// Connect to ShiftPlanning
		$connection = new spConnect();
		$sp = $connection->connectToShiftPlanning();
	
		$shift_start = date("Y-m-d 00:00:00", $_GET['start']);
		$shift_end = date("Y-m-d 00:00:00", $_GET['end']);

		$sql = 'uid='. $_GET['uid'] . ' AND shift_end != "0000-00-00 00:00:00" AND shift_start != shift_end AND shift_start > "' . $shift_start . '" AND shift_end < "' . $shift_end . '"';
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
			$timecard = new Timecards;
						
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
			$_POST['Forgot']['submissionTime'] = date("Y-m-d H:i:s", time());
			$_POST['Forgot']['processed'] = 1;
			$_POST['Forgot']['flag'] = 0;
			$_POST['Forgot']['comment'] = "User Comment: " . $_POST['Forgot']['comment'];
			
			$model->attributes = $_POST['Forgot'];
			
			// Validate our model via basic validation rules
			if ($model->validate()) {
				// Save our model now. =)
				$model->save();
				$timecard->uid =$_POST['Forgot']['uid'];
				$timecard->shift_start = $_POST['Forgot']['start'];
				$timecard->shift_end = $_POST['Forgot']['end'];
			
				$timecard->save();
				
				// output success messages
				echo "Your submission has been sucessfully saved. This window will automatically close in a few seconds";
				}
			else	// Debugging
				print_r($model->getErrors());
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{		
		$model=Users::model()->findByPk($id);
		if($model===null) {
			$this->layout="//layouts/column1";
			throw new CHttpException(404,'The requested user could not be found. Please verify the user ID in the URL field before trying again.');
			}
		return $model;
	}
}
