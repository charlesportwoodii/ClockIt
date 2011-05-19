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
				'actions'=>array('index','changepassword','update','forgot','viewforgot','viewforgotcomments','schedule','getUpcommingShifts','scheduledShifts'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	private function connectToShiftPlanning() {
		// Connect to ShiftPlanning
		Yii::import("application.extensions.shiftplanning.YShiftPlanning");
		$sp = new YShiftPlanning(
			array(
				'key' => Yii::app()->params['SPAPIKey']
				)
			);
		
		// Return our Model
		return $sp;
		}
		
	public function actionIndex()
	{
		// Initialize the ShiftPlanning API
		$sp = $this->connectToShiftPlanning();

		// Set the Number of Messages to show and to pass to our view
			$numberOfMessages = 2;
		
		/********************************************************************
		*	The content apccached here is /globally/ accessable. We want this 
		*	View to be available to all users
		*********************************************************************/
		if(Yii::app()->apccache->get('HomeWallMessages')===false) {
			// Retrieve a list of messages from ShiftPanning Wall
			$messages = $sp->getWallMessages();
		
			// Throw it in the apccache
			Yii::app()->apccache->set('HomeWallMessages', $messages, 1800);
			}
		
					
		// Render the view
		$this->render('index', 
			array( 
			'messages'=>Yii::app()->apccache->get('HomeWallMessages'),
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
		$sp = $this->connectToShiftPlanning();
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
				Yii::app()->user->setFlash('updateProfile',"Your password has sucessfully been changed.");
				
				// Parsing for ShiftPlanning
				$birthday = explode("-",$model->birthday);
				// Push new data to ShiftPlanning
				$sp = $this->connectToShiftPlanning();
				$update = $sp->updateEmployee(Yii::app()->user->getState('spId'), array('name'=>$model->dispName, 'address'=>$model->address, 'city'=>$model->city, 'state'=>$model->state, 'zip'=>$model->zip, 'birth_day'=>$birthday[2], 'birth_month'=>$birthday[1]));
				
				}
			}
		$this->render('update', array('model'=>$model));
	}
	
	public function actionForgot() 
	{
		$model = new Forgot;
		if(isset($_POST['Forgot']))
		{
			$model->attributes = $_POST['Forgot'];
			$model->uid = Yii::app()->user->id;
			$model->submissionTime = date("Y-m-d H:i:s", time());
			if ($model->validate()) {
				$model->save();
				Yii::app()->user->setFlash('forgotSubmitted',"You have submission has been accepted, and will be reviewed before the next scheduled pay period.");
				unset($_POST['Forgot']);
				$_POST['Forgot'] = array('uid'=>'', 'start'=>'', 'end'=>'', 'type'=>'');
				$model->attributes = $_POST['Forgot'];
				}
		}
		$this->render('forgot', array('model'=>$model));
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
		$dataProvider=new CActiveDataProvider(
			'Forgot',
			array(
				'criteria'=>array(
					'condition'=>'uid='. Yii::app()->user->id . ' AND id=' .$_GET['id'],
				),
			)
		);
		
		// If we didn't find a record that matched we need to redirect to a 403 page
		if ($dataProvider->getItemCount() == 0)
			throw new CHttpException(403,'You do not have permission to view this comment');
			
		// Render the view
		$this->render('viewforgotcomments', array('dataProvider'=>$dataProvider));
	}
	
	public function actionSchedule() 
	{
		// Set a 1 Column page layout
		$this->layout='//layouts/column1';
		$this->render('schedule', array('dataProvider'=>$dataProvider));
	}
	
	public function actionScheduledShifts() {
		$sp = $this->connectToShiftPlanning();
		$dataProvider=new CActiveDataProvider(
			'Timecards',
			array(
				'criteria'=>array(
					'condition'=>'uid='. Yii::app()->user->id . ' AND shift_end != "0000-00-00 00:00:00"',
				),
			)
		);
		$this->renderPartial('_scheduledShifts', array('sp'=>$sp, 'dataProvider'=>$dataProvider), false, true);
		}
}
	
	