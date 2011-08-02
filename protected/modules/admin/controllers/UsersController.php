<?php

class UsersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
				'actions'=>array('index','view','update','create','delete'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->role<=2',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			// Encrypt the password
			$model->password = Users::model()->_encryptHash($model->email, $_POST['Users']['password'], Yii::app()->params['encryptionKey']);
			if ($model->validate()) {
				// Connect to ShiftPlanning
				$connection = new spConnect();
				$sp = $connection->connectToShiftPlanning();
				
				// Try to create a user
				$response = $sp->createEmployee(array('email'=>$model->email, 'password'=>$_POST['Users']['password'], 'status'=>$model->active, 'group'=>$model->role, 'name'=>$model->dispName, 'cell_phone'=>$model->phoneNumber));
				// If we sucessfully added a user to ShiftPlanning
				//print_r($response);
				if ($response['status']['code'] == 1) {
					
					// Automatically link the accounts for later lookup
					$model->spUid = $response['data']['id'];
					
					// And save the user to our database
					$model->save();
					
					// Redirect to the view
					Yii::app()->user->setFlash('success', 'User: ' . $model->dispName . ' has been created');
					$this->redirect(array('index'));
					}
				}
			else {
				print_r($response);
				$model->password = NULL;
				}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		// Set the model password to NULL so that nothing gets set
		$model->password = NULL;
		if(isset($_POST['Users']))
		{
			$model->attributes = $_POST['Users'];
			if ($_POST['Users']['password'] != NULL)
				$model->password = Users::model()->_encryptHash($model->email, $_POST['Users']['password'], Yii::app()->params['encryptionKey']);
			else {
				$password = Users::model()->findbypk($model->uid);
				$model->password = $password->password;
				unset($password);
				}
				
			if ($model->validate()) {
				// Connect to ShiftPlanning
				$connection = new spConnect();
				$sp = $connection->connectToShiftPlanning();
				
				// Try to update a user
				$birthData = explode(" ", $model->birthday);
				$birthData = explode("-", $birthData[0]);
				
				// Proper Role fixing
				$role = $model->role;
				if ($model->role <=2)
					$role = 2;
				
				// We need to two a different request if the user changed the password.
				// If they did change it, we need to pass a new password to SP.
				if ($_POST['Users']['password'] != NULL)
				{
					$response = $sp->updateEmployee($model->spUid, array('email'=>$model->email, 'password'=>$_POST['Users']['password'], 'group'=>$role, 'name'=>$model->dispName, 'cell_phone'=>$model->phoneNumber, 'address'=>$model->address, 'city'=>$model->city, 'state'=>$model->state, 'zip'=>$model->zip, 'birth_day'=>$birthData[2], 'birth_month'=>$birthData[1]));
					}
				else {// Otherwise we need to not transmit the password
					$response = $sp->updateEmployee($model->spUid, array('email'=>$model->email, 'group'=>$role, 'name'=>$model->dispName, 'cell_phone'=>$model->phoneNumber, 'address'=>$model->address, 'city'=>$model->city, 'state'=>$model->state, 'zip'=>$model->zip, 'birth_day'=>$birthData[2], 'birth_month'=>$birthData[1]));
					}
				// If we sucessfully updated our user
				if ($response['status']['code'] == 1) {					
					// And save the user to our database
					
					// Hack our birthday back to prevent logging on every event
					$model->birthday .= " 00:00:00";
					
					$model->save();
					
					// Redirect to the view
					
					Yii::app()->user->setFlash('success', 'User: ' . $model->dispName . ' has been updated');
					$this->redirect(array('index'));
					}
				else {
					Yii::app()->user->setFlash('error',$response['status']['error']);
					$model->password = NULL;
					}
				}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model= $this->loadModel($id);
			$model->active = 0;
			if($model->save())
				echo "User has been updated";
			else
				echo "User has not been updated";

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('index',array(
			'model'=>$model,
		));
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

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
