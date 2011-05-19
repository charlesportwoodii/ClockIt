<?php

class StatisticsController extends Controller
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
				'actions'=>array('index', 'global', 'forgot', 'user'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->role<=2',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$connection=Yii::app()->db;
		
		$gKarma = array();
		// Select Violations
		$sql="SELECT uid, dispName, (100- absences * 5 - tardies * 3 - violations * 2 - forgot) AS karma FROM users ORDER BY karma DESC";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach ($data as $i)
			$gKarma[] = array($i['dispName'], (int)$i['karma'], $i['uid']);

		$this->render('index', array(
			'gKarma'=>$gKarma,
			));
	}
	
	public function actionForgot()
	{
		$connection=Yii::app()->db;
		
		if (!isset($_POST['Time'])) {
			$t1 = date("Y-m-d", strtotime("midnight first day of this month"));
			$t2 = date("Y-m-d",  strtotime("midnight first day of next month"));
			}
		else {
			$t1 = $_POST['Time']['time'];
			list($year,$month,$day) = explode('-', $t1);
			$t2 = $year . '-' . ($month+1) % 13 . '-01';
			}

		$time = array();
		$sql="SELECT type, COUNT(type) AS count FROM forgot WHERE submissionTime BETWEEN '$t1%' AND '$t2%' GROUP BY type";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach($data as $i) {
			switch($i['type']) {
				case 1:
					$type = "System Submission";
				break;
				case 2:
					$type = "Late Clock In";
				break;
				case 3:
					$type = "Late Clock Out";
				break;
				case 4:
					$type = "Forgot Entire Shift";
				break;
				case 5:
					$type = "Manual Submission";
				break;
				default:
					$type = "Unknown Classification";
				}
			$time[] = array($type, (int)$i['count']);
			}
		
		$time2 = array();
		$sql="SELECT type, COUNT(type) AS count FROM forgot GROUP BY type";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach($data as $i) {
			switch($i['type']) {
				case 1:
					$type = "System Submission";
				break;
				case 2:
					$type = "Late Clock In";
				break;
				case 3:
					$type = "Late Clock Out";
				break;
				case 4:
					$type = "Forgot Entire Shift";
				break;
				case 5:
					$type = "Manual Submission";
				break;
				default:
					$type = "Unknown Classification";
				}
			$overall[] = array($type, (int)$i['count']);
			}

			$this->render('forgot', array(
			'time'=>$time,
			'overall'=>$overall,
			'timestamp'=>$t1,
			));
	}
	
	public function actionUser()
	{
		if (!isset($_POST['Time'])) {
			$t1 = date("Y-m-d", strtotime("midnight first day of this month"));
			$t2 = date("Y-m-d",  strtotime("midnight first day of next month"));
			}
		else {
			$t1 = $_POST['Time']['time'];
			list($year,$month,$day) = explode('-', $t1);
			$t2 = $year . '-' . ($month+1) % 13 . '-01';
			}
		
		$model = new Users;
		$connection=Yii::app()->db;

		
		if (isset($_REQUEST['uid'])) {
			$model->uid = $_REQUEST['uid'];
			}
		else if (isset($_POST['Users']['uid'])) {
			$model->uid = $_POST['Users']['uid'];
			}
		else
			$model->uid = Yii::app()->user->id;
		
		$uid = $model->uid;
		
		$time = array();
		$sql="SELECT type, COUNT(type) AS count FROM forgot WHERE submissionTime BETWEEN '$t1%' AND '$t2%' AND uid = '$uid' GROUP BY type";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach($data as $i) {
			switch($i['type']) {
				case 1:
					$type = "System Submission";
				break;
				case 2:
					$type = "Late Clock In";
				break;
				case 3:
					$type = "Late Clock Out";
				break;
				case 4:
					$type = "Forgot Entire Shift";
				break;
				case 5:
					$type = "Manual Submission";
				break;
				default:
					$type = "Unknown Classification";
				}
			$time[] = array($type, (int)$i['count']);
			}
			
		$user = array();
		$sql="SELECT violations, tardies, absences, forgot, assists FROM users WHERE uid = '$uid'";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		
		foreach ($data as $i) {
			$user[] = $i;
			}
			
		$this->render('user', array(
			'time'=>$time,
			'user'=>$user,
			'timestamp'=>$t1,
			'model'=>$model
			));
	}
	
	public function actionGlobal()
	{
		$connection=Yii::app()->db;
		
		$absences = array();
		// absences
		$sql="SELECT uid, dispName, absences FROM users WHERE absences > 0 ORDER BY absences DESC LIMIT 0, 7";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach ($data as $i)
			$absences[] = array($i['dispName'], (int)$i['absences']);
		
		$tardies = array();
		// Tardies
		$sql="SELECT uid, dispName, tardies FROM users WHERE tardies > 0 ORDER BY tardies DESC LIMIT 0, 7";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach ($data as $i)
			$tardies[] = array($i['dispName'], (int)$i['tardies']);
		
		$forgot = array();
		// Forgot
		$sql="SELECT uid, dispName, forgot FROM users WHERE forgot > 0 ORDER BY forgot DESC LIMIT 0, 7";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach ($data as $i)
			$forgot[] = array($i['dispName'], (int)$i['forgot']);

		$violations = array();
		// Select Violations
		$sql="SELECT uid, dispName, violations FROM users WHERE violations > 0 ORDER BY violations DESC LIMIT 0, 7";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach ($data as $i)
			$violations[] = array($i['dispName'], (int)$i['violations']);
		
		$Karma = array();
		// Select Violations
		$sql="SELECT dispName, (100- absences * 5 - tardies * 3 - violations * 2 - forgot) AS karma FROM users ORDER BY karma DESC";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		foreach ($data as $i)
			$Karma[] = array($i['dispName'], (int)$i['karma']);

		$this->render('global', array(
			'absences'=>$absences,
			'tardies'=>$tardies,
			'forgot'=>$forgot,
			'violations'=>$violations,
			'Karma'=>$Karma,
			)
		);
	}
}