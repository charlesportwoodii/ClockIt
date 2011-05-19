<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id;
			
	public function authenticate()
    {
		$this->username = $this->username . "@acu.edu";
        $record=Users::model()->findByAttributes(array('email'=>$this->username));
        if($record===null)
            $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
        else if($record->password!==Users::model()->_encryptHash($this->username, $this->password, Yii::app()->params['encryptionKey']))
            $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
		else if ($record->active == 0)
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
        else
        {
			$this->_id = $record->uid;
			$this->setState('spId', $record->spUid);
			$this->setState('dispName', $record->dispName);
			$this->setState('active', $record->active);
            $this->setState('role', $record->role);
			$this->setState('email', $record->email);
			$this->setState('firstLogin', $record->firstLogin);
			if ($record->firstLogin == 0) {
				Yii::import("application.extensions.shiftplanning.YShiftPlanning");
				$sp = new YShiftPlanning(
					array(
						'key' => Yii::app()->params['SPAPIKey'],
						'token' => Yii::app()->user->getState('appToken'),
						)
					);
				$response = $sp->doLogin(
					array(
						'username' => $this->username,		// Load the current usernamed as defined upon login
						'password' => $this->password,					// Authenticate with the SP Password
						)	
					);
				if ($response['status']['code'] == 1) {
					$data = $sp->getSession();
					$uid = $this->_id;
					$appToken = Yii::app()->user->getState('appToken');
					$connection=Yii::app()->db;
					// Create the SQL statement
					$sql="UPDATE users SET dispName = :name, phoneNumber = :phoneNumber, address = :address, city = :city, state = :state, zip = :zip, appToken= :appToken WHERE uid = :uid";
					$command = $connection->createCommand($sql);
					// Bind the parameters
					
					$command->bindParam(":uid", $uid, PDO::PARAM_STR);
					$command->bindParam(":appToken", $appToken, PDO::PARAM_STR);
					$command->bindParam(":name", $data['employee']['name'], PDO::PARAM_STR);
					$command->bindParam(":phoneNumber", $data['employee']['cell_phone'], PDO::PARAM_STR);
					$command->bindParam(":address", $data['employee']['address'], PDO::PARAM_STR);
					$command->bindParam(":city", $data['employee']['city'], PDO::PARAM_STR);
					$command->bindParam(":state", $data['employee']['state'], PDO::PARAM_STR);
					$command->bindParam(":zip", $data['employee']['zip'], PDO::PARAM_STR);
					Yii::app()->user->setState('firstLogin', 0);
					// Execute the command
					$command->execute();
					}
				else
					$this->setState('firstLogin', '1');
				}
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

		
	public function getId()
	{
    return $this->_id;
	}
}