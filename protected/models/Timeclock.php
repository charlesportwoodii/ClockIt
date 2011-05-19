<?

/**
 * Timeclock class.
 * Timeclock Model
 */
class Timeclock extends CFormModel {
	
	public $uid;
	public $cStatus;
	public $timestamp;
	public $allowedIps;
	
	public function rules()
	{
		return array(
			array('uid', 'required'),
			array('uid', 'numerical'),
			array('uid', 'length', 'is'=>13),
			array('uid', 'authenticate'),
			);
		}
	
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors()) {		
			// Search to see if we can find a user with that uid
			$record = Users::model()->findByAttributes(array('uid'=>$this->uid));
			// Validation checks			
			if ($record == NULL)																// Check to make sure we found a user
				$this->addError('uid','The barcode you supplied is invalid.');
			else if (!$record->active) 															// Make sure the user is active
				$this->addError('uid','Your account is currently not active. If you believe this to be in error, please contact your HR Supervisor');
			else if ($this->CheckTime(date("H:i",time()), "00:15", "6:55"))						// Make sure they are clocking in a valid time
				$this->addError('uid','You may not clock in between the hours of 12:15am and 6:55am.');
			else if (!in_array(Yii::app()->request->userHostAddress, $this->allowedIps)) 		// Check for valid ip
				$this->addError('uid','You may not clock in or out from this location. Please do not try this request again');
			else {
				$connection=Yii::app()->db;
				
				// Get the current user's status and update the model
				$sql="SELECT cStatus FROM users WHERE uid = :uid";				
				$command = $connection->createCommand($sql);
				$command->bindParam(":uid", $this->uid, PDO::PARAM_STR);
				$data = $command->query();
				foreach($data as $row)
					$this->cStatus = $row['cStatus'];	
				return true;
				}							
			return false;
		}
		return false;
	}
	
	public function updateIps($ips) {
		$this->allowedIps = unserialize($ips);
		}
		
	private function CheckTime($currentTime, $startTime, $endTime) {
		// written 11/26/2006 by Patrick H. (patrickh@gmail.com)
		//
		// the time passed must meet all the below criteria to return 1 (true):
		//
		// - current hour needs to be equal or greater than start hour
		// - current hour needs to be equal or less than end hour
		// - current minute needs to be equal or greater than start minute (if current hour is ok)
		// - current minute needs to be equal or less than end minute (if current hour is ok)
		//
		// if any of those checks does not pass, it will return 0 (false)

		global $cHour;
		global $cMin;
		global $sHour;
		global $sMin;
		global $eHour;
		global $eMin;

		// break up current time
		$now = explode(":",$currentTime);
		$cHour = intval($now[0]);	// current time - hour
		$cMin = intval($now[1]);	// current time - minute

		// break up start time
		$start = explode(":",$startTime);
		$sHour = intval($start[0]);	// start of range - hour
		$sMin = intval($start[1]);	// start of range - minute

		// brek up end time
		$end = explode(":",$endTime);
		$eHour = intval($end[0]);	// end of range - hour
		$eMin = intval($end[1]);	// end of range - minute

		// this is the variable used to track the result of the checks
		$pass = true;

		if($sHour <= $eHour){
			// the range is on the same day

			// compare to the start hour
			if($cHour < $sHour){
				$pass = false;
			}

			// compare to the end hour
			if($cHour > $eHour){
				$pass = false;
			}

			// compare to the start min
			if($cHour == $sHour){
				if($cMin < $sMin){
					$pass = false;
				}
			}

			// compare to the end min
			if($cHour == $eHour){
				if($cMin > $eMin){
					$pass = false;
				}
			}

		} else {
			// the range is overnight, so the logic is a little different

			if( ($cHour < $sHour) && ($cHour > $eHour) ){
				$pass = false;
			}

			// compare to the start min
			if($cHour == $sHour){
				if($cMin < $sMin){
					$pass = false;
				}
			}

			// compare to the end min
			if($cHour == $eHour){
				if($cMin > $eMin){
					$pass = false;
				}
			}

		}

		// done with check, return the result
		if($pass == false){
			return FALSE;	// failed
		} else {
			return TRUE;	// passed
		}

		}
	}
?>