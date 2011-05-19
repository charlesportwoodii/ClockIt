<?
/**
 *	System Cron Job | 
 *	Clocks users out at specified time (Preferably Midnight), and manages forgotten shifts
 *	Attempts to resolve forgotten shifts automagically.
 *	ShiftPlanning requires Session support, so this has to be called via Lynx\CUrl\wGet on localhost with the appropriate passkey
 **/
class CronController extends CController
{
	public $connection; 
	public $spConnection;
	
	// Primary Action
	public function actionIndex() {
	
		// Check to make sure we have the right authentication details. Localhost and with Key only
		if ( Yii::app()->request->userHostAddress != "127.0.0.1" && $_GET['key'] != "1NHFN2892B2BFL0AB82PQ9DJ3NDK")
		{
			echo "You must run this script from the command line";
			break;
		}
		// Establish a database connection and store it
		$this->connection = Yii::app()->db;
		
		// Establish a connection to ShiftPlanning and store it
		$connection = new spConnect();
		$this->spConnection = $connection->connectToShiftPlanning();
		
		// Login to ShiftPlanning with our system login
		$response = $this->spConnection->doLogin(
				array(
					'username' => Yii::app()->params['adminEmail'],		// ShiftPlanning Username
					'password' => Yii::app()->params['SPPassword'],		// ShiftPlanning Password
					)	
				);
				
		 // Clock users currently in the system out
		$this->clockAllUsersOut();		 
		
		// Process Forgotten Shifts
		$this->processForgot();
		
		// Run maintenance actions for all tables
		$this->tableCheck();

		// Flush all caches
		$this->flushCaches();
		
		// De-authenticate from ShiftPlanning
		$this->spConnection->doLogout();
		
		echo "Cron Completed\n";
		}
	
	// Processes Reported and Forgotten Shifts and translates that information to the actual shift manager
	private function processForgot()
	{
		// Select the appropriate data for processing, Flagged items are the one we are interested in
		$dataReader = $this->connection->createCommand('SELECT id, asid FROM forgot WHERE flag = 1')->queryAll();
		
		foreach ($dataReader as $forgot)
		{
			// Load the appropriate forgot model for this entry
			$model = Forgot::loadModel($forgot['id']);
			
			// Load the appropriate timeclock model for this entry
			$punch = Timecards::loadModel($forgot['asid']);
			
			// Set the shift end time
			$punch->shift_end = $model->end;
			
			// Save and log to output buffer
			if ( !$punch->save() )
			{
				echo "<pre>";
				print_r($punch->getErrors());
				echo "</pre>";
			}
			
			// Mark our Forgot model as processed
			$model->processed = 1;
			$model->flag = 0;			
			
			// save and log to output buffer
			if ( !$model->save() )
			{
				echo "<pre>";
				print_r($model->getErrors());
				echo "</pre>";
			}
			
			$user = Users::loadModel($punch['uid']);
			
			switch($model['type'])
			{
				case 1:
					$user->forgot++;
				break;
				case 2:
					$user->violations++;
				break;
				case 3:
					$user->tardies++;
				break;
				case 4:
					$user->violations++;
				break;
				case 5:
					$user->forgot++;
				break;
			}
			
			if ( !$user->save() )
			{
				echo "<pre>";
				print_r($user->getErrors());
				echo "</pre>";
			}
			// Destroy the models to save memory
			unset($user);
			unset($model);
			unset($punch);
		}
	}
	
	// Retrieves the last shift of a user from shift planning
	private function getLastShift($uid)
	{
		// Get the SPUID of the user
		$spuid = Users::getSPuid($uid);
		
		// Retrieve a listing of all shifts for yesterday
		$response = $this->spConnection->getShifts(
				array(
					'start_date'=>date("Y-m-d", strtotime("Yesterday")), 
					'end_date'=>date("Y-m-d", strtotime("Yesterday")), 
					'mode'=>'employees',
					'employees'=>$spuid
					)
				);
		
		// Return the formatted timestamp
		return date("Y-m-d h:i:s", strtotime("Yesterday " . $response['data'][(sizeof($response['data'])-1)]['end_time']['time']));
	}
	
	// Files Forgot reports for shifts that don't have the correct end time (0000-00-00 00:00:00)
	private function fileForgot($timecard)
	{
		// Create a new forgot model
		$model = new Forgot;
		
		// We need to be able to handle the exception of someone clocked in when they weren't schedule, and we don't submit
		// Flag forces it to go under review
		
		$flag = 0;
		$end = $this->getLastShift($timecard['uid']);
		if ( $end != NULL )
			$flag = 1;	
		
		// Set the appropriate attributes
		$model->attributes = array(
			'uid' => $timecard['uid'],
			'asid' => $timecard['pid'],
			'submissionTime' => date("Y-m-d h:i:s", time()),
			'start' => $timecard['shift_start'],
			'end' => $this->getLastShift($timecard['uid']),
			'type' => '1',
			'comment' => 'System Submission',
			'flag' => $flag,
			'processed' => '0'
			);
		
		// Save the model
		if ( !$model->save() )
		{
			echo "<pre>";
			print_r($model->getErrors());
			echo "</pre>";
		}
		
		// Unset the model
		unset($model);
	}
	
	// Clocks all users out of the system
	private function clockAllUsersOut()
	{
		// Clock all users out of the system
		$this->connection->createCommand('UPDATE users SET cStatus = 0 WHERE cStatus =1')->execute();
		
		// Retrieve all the shifts that are still registered as clocked in
		$dataReader = $this->connection->createCommand('SELECT pid FROM timecards WHERE shift_end = 0')->queryAll();
		
		// Iterate through each shift
		foreach($dataReader as $punch)
		{
			// Load the appropriate data from the model
			$model = Timecards::loadModel($punch['pid']);
			
			// Update the shift end time
			$model->shift_end = date("Y-m-d h:i:s", time());
			
			// Update the record
			$model->update();
			
			$this->fileForgot($model);
			
		}
	}
	
	// Flushes APC and Memcache
	private function flushCaches()
	{
		// Flush all caching mechanisms to optimize performance
		Yii::app()->apccache->flush();
		Yii::app()->memcache->flush();
	}
	
	// Runs table optimizations and logs the entries
	private function tableCheck()
	{
		
		// Run the repair table command
		$this->connection->createCommand('REPAIR TABLE  `announcements` ,  `comments` ,  `forgot` ,  `roles` ,  `serverVariables` ,  `timecards` ,  `users` ,  `watchdog`')->execute();
		
		// Log the action
		$model = new Watchdog;
		$model->attributes = array('action'=>'REPAIR TABLE', 'model'=>'CRON', 'stamp'=>date("Y-m-d h:i:s", time()), 'user_id'=>'SYSTEM');
		$model->save();
		unset($model);
		
		// Run the optmize table command
		$this->connection->createCommand('OPTIMIZE TABLE  `announcements` ,  `comments` ,  `forgot` ,  `roles` ,  `serverVariables` ,  `timecards` ,  `users` ,  `watchdog`')->execute();
		
		// Log the action
		$model = new Watchdog;
		$model->attributes = array('action'=>'OPTIMIZE TABLE', 'model'=>'CRON', 'stamp'=>date("Y-m-d h:i:s", time()), 'user_id'=>'SYSTEM');
		$model->save();
		unset($model);
		
		// Run the analyze table command
		$this->connection->createCommand('ANALYZE TABLE  `announcements` , `comments` , `forgot` , `roles` , `serverVariables` , `timecards` , `users` , `watchdog`')->execute();
		
		// Log the action
		$model = new Watchdog;
		$model->attributes = array('action'=>'ANALYZE TABLE', 'model'=>'CRON', 'stamp'=>date("Y-m-d h:i:s", time()), 'user_id'=>'SYSTEM');
		$model->save();
		unset($model);
	}
	
}

?>