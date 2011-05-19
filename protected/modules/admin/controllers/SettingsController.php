<?php

class SettingsController extends Controller
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
				'actions'=>array('index','view','update'),
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
		$model = $this->loadModel($id);
		
		$model->value = implode("\n",unserialize($model->value));
		$this->render('view',array('model'=>$model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->value = implode(",",unserialize($model->value));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ServerVariables']))
		{
			$_POST['ServerVariables']['value'] = serialize(explode(",",$_POST['ServerVariables']['value']));
			$model->attributes=$_POST['ServerVariables'];
			if($model->save()) {
				Yii::app()->user->setFlash('success','Setting: ' . $model->name . ' has been updated.');
				$this->redirect(array('index'));
				}
		}

		$this->render('update',array('model'=>$model));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new ServerVariables('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ServerVariables']))
			$model->attributes=$_GET['ServerVariables'];

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
		$model=ServerVariables::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='server-variables-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
