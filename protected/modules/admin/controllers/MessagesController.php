<?php

class MessagesController extends Controller
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Messages();
		if (isset($_POST['Messages'])) {
			$model->attributes = $_POST['Messages'];
			if ($model->validate()) {
				// Connect to ShiftPlanning
				$connection = new spConnect();
				$sp = $connection->connectToShiftPlanning();
				
				$response = $sp->createWallMessage(array('title'=>$model->title, 'post'=>$model->post, 'sticky'=>0));
				if ($response['status']['code'] == 1) {
					Yii::app()->user->setFlash('success', 'Message has been posted.');
					$this->redirect('index');
					}
				}
			}
			
		$this->render('create', array('model'=>$model));
		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		// Load our Message Model with the appropriate data
		$model = $this->loadModel($id);
		
		// If the returned model is NULL, bail
		if ($model===NULL)
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
		if (isset($_POST['Messages'])) 
		{
			$model->attributes = $_POST['Messages'];
			
			if ($model->validate()) {
				// Connect to ShiftPlanning
				$connection = new spConnect();
				$sp = $connection->connectToShiftPlanning();
				
				$response = $sp->deleteWallMessage($id, array('delete'=>'message'));
				if ($response['status']['code'] == 1) {
					$response = $sp->createWallMessage(array('title'=>$model->title, 'post'=>$model->post, 'sticky'=>0));
					if ($response['status']['code'] == 1) {
						Yii::app()->user->setFlash('success', 'Message has been posted.');
						$this->redirect('../../index');
						}
					}
				print_r($response);
				}	
		}	
		
		// render our view
		$this->render('update',array('model'=>$model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// Only perform this task if it was a POST request.
		if(Yii::app()->request->isPostRequest)
		{
			// Connect to ShiftPlanning
			$connection = new spConnect();
			$sp = $connection->connectToShiftPlanning();
			
			// Delete the message
			$sp->deleteWallMessage($id, array('delete'=>'message'));
			
			// Do an AJAX Return
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
		// Impor the array to dataProvider modules
		Yii::import('application.extensions.arrayDataProvider.*');
		
		// Connect to ShiftPlanning
		$connection = new spConnect();
		$sp = $connection->connectToShiftPlanning();
		
		// Retrieve our data
		$response = $sp->getWallMessages();
		
		// If our data response doesn't contain any data, we should set it to be an empty array as opposed to a NULL value (CGridView expect an array)
		if ($response['data'] == NULL) {
			$response['data'] = array();
			}
		
		// Fix our response so that our items that contain arrays are removed
		$newResponse = array();
		foreach ($response['data'] as $item) {
			// Reduce the user array to just the poster's name (this should be transparent thanks to dispName)
			$item['user'] = $item['user']['name'];
			
			// Build our new response item by item
			$newResponse[] = $item;
			}	
		
		// Build the data provider
		$dataProvider = new ArrayDataProvider($newResponse);
		
		// Render the view
		$this->render('index', array('dataProvider'=>$dataProvider));
		
	}
	
	private function loadModel($id) {
		// Create a new model
		$model = new Messages;
		
		// Connect to ShiftPlanning
		$connection = new spConnect();
		$sp = $connection->connectToShiftPlanning();
		
		// ShiftPlanning does not support GET of a message wall by an id, so we have to get them all
		// And then return the one we want
		$response = $sp->getWallMessages();
		
		if ($response['status']['code'] == 1) {
			foreach ($response['data'] as $item) {
				if ($item['id'] == $id) {
					// Build our data
					$model->attributes = array(
						'title' => $item['title'],
						'post' => $item['post'],
						);
					$model->id = $id;
					return $model;
					}
				}
			}
			
		return NULL;
		}
}
